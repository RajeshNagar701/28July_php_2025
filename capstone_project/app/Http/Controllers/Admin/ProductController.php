<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products   = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255|unique:products',
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|numeric|min:0',
            'original_price'   => 'nullable|numeric|min:0',
            'description'      => 'nullable|string',
            'image'            => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sizes'            => 'nullable|string',
            'colors'           => 'nullable|string',
            'quantity'         => 'required|integer|min:0',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image_alt'        => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'name', 'category_id', 'price', 'original_price',
            'description', 'sizes', 'colors', 'quantity',
            'meta_title', 'meta_description', 'image_alt',
        ]);

        $data['slug']     = Str::slug($request->name);
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['status']   = $request->has('status') ? 1 : 0;
        $data['image']    = $request->file('image')->store('products', 'public');

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'             => 'required|string|max:255|unique:products,name,' . $product->id,
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|numeric|min:0',
            'original_price'   => 'nullable|numeric|min:0',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sizes'            => 'nullable|string',
            'colors'           => 'nullable|string',
            'quantity'         => 'required|integer|min:0',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image_alt'        => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'name', 'category_id', 'price', 'original_price',
            'description', 'sizes', 'colors', 'quantity',
            'meta_title', 'meta_description', 'image_alt',
        ]);

        $data['slug']     = Str::slug($request->name);
        $data['featured'] = $request->has('featured') ? 1 : 0;
        $data['status']   = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            // Delete old gallery
            if ($product->gallery) {
                foreach ($product->gallery as $img) {
                    Storage::disk('public')->delete($img);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        if ($product->gallery) {
            foreach ($product->gallery as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $product->delete();
        return back()->with('success', 'Product deleted successfully!');
    }
}
