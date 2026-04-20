<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page with featured products and categories.
     */
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->active()->featured()->latest()->take(8)->get();

        $categories = Category::active()
            ->withCount('products')->take(6)->get();

        $newArrivals = Product::with('category')
            ->active()->latest()->take(8)->get();

        $bestSellers = Product::with('category')
            ->withCount('orderItems')
            ->active()
            ->orderByDesc('order_items_count')
            ->take(8)->get();

        return view('frontend.home', compact(
            'featuredProducts', 'categories', 'newArrivals', 'bestSellers'
        ));
    }

    /**
     * Live search via AJAX.
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $products = Product::with('category')
            ->active()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(8)
            ->get()
            ->map(fn($p) => [
                'id'    => $p->id,
                'name'  => $p->name,
                'slug'  => $p->slug,
                'price' => number_format($p->price, 2),
                'image' => $p->image ? asset('storage/' . $p->image) : asset('images/no-image.png'),
            ]);

        return response()->json($products);
    }
}
