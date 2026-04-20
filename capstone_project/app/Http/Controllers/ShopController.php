<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Shop listing page with filters.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->where('sizes', 'like', '%' . $request->size . '%');
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->where('colors', 'like', '%' . $request->color . '%');
        }

        // Search
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) => $sq->where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%"));
        }

        // Sorting
        match ($request->get('sort', 'latest')) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name_asc'   => $query->orderBy('name'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::active()->withCount('products')->get();

        // Available sizes & colors for filter dropdowns
        $allSizes  = ['6', '7', '8', '9', '10', '11', '12'];
        $allColors = ['Black', 'White', 'Red', 'Blue', 'Brown', 'Grey', 'Green'];

        return view('frontend.shop', compact(
            'products', 'categories', 'allSizes', 'allColors'
        ));
    }

    /**
     * Product details page.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user']);

        $relatedProducts = Product::with('category')
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)->get();

        $reviews      = $product->reviews()->approved()->with('user')->latest()->get();
        $avgRating    = $reviews->avg('rating') ?? 0;
        $ratingCounts = $reviews->groupBy('rating')->map->count();

        // Check if current user already reviewed
        $userReview = null;
        if (auth()->check()) {
            $userReview = $product->reviews()
                ->where('user_id', auth()->id())->first();
        }

        // Check if in wishlist
        $inWishlist = auth()->check()
            ? $product->wishlists()->where('user_id', auth()->id())->exists()
            : false;

        return view('frontend.product-detail', compact(
            'product', 'relatedProducts', 'reviews',
            'avgRating', 'ratingCounts', 'userReview', 'inWishlist'
        ));
    }

    /**
     * Store a product review.
     */
    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // One review per user per product
        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['rating' => $request->rating, 'comment' => $request->comment, 'approved' => 0]
        );

        return back()->with('success', 'Review submitted! It will appear after admin approval.');
    }

    /**
     * Category page (filtered shop).
     */
    public function category(Category $category)
    {
        $products   = $category->products()->active()->latest()->paginate(12);
        $categories = Category::active()->withCount('products')->get();

        $allSizes  = ['6', '7', '8', '9', '10', '11', '12'];
        $allColors = ['Black', 'White', 'Red', 'Blue', 'Brown', 'Grey', 'Green'];

        return view('frontend.shop', compact('products', 'categories', 'category', 'allSizes', 'allColors'));
    }
}
