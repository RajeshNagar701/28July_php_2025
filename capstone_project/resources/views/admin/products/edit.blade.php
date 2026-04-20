@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')
<div class="page-header">
    <div>
        <h2>Edit Product</h2>
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-4">
        <!-- LEFT COLUMN -->
        <div class="col-lg-8">
            <div class="admin-form-card mb-4">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Basic Information</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Selling Price (₹) *</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Original Price (₹)</label>
                        <input type="number" name="original_price" class="form-control" value="{{ old('original_price', $product->original_price) }}" step="0.01" min="0">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="admin-form-card mb-4">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Variants & Inventory</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Available Sizes <small class="text-muted">(comma separated)</small></label>
                        <input type="text" name="sizes" class="form-control" value="{{ old('sizes', is_array($product->sizes) ? implode(',', $product->sizes) : $product->sizes) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Available Colors <small class="text-muted">(comma separated)</small></label>
                        <input type="text" name="colors" class="form-control" value="{{ old('colors', is_array($product->colors) ? implode(',', $product->colors) : $product->colors) }}">
                    </div>
                </div>
            </div>

            <div class="admin-form-card">
                <h6 class="fw-700 mb-4 border-bottom pb-3">SEO Settings</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">
            <div class="admin-form-card mb-4">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Main Image</h6>
                @if($product->image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/'.$product->image) }}" style="max-height:150px; border-radius:10px;" alt="{{ $product->name }}">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <div class="small text-muted mt-1">Upload to replace the current image.</div>
            </div>

            <div class="admin-form-card mb-4">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Gallery Images</h6>
                @if($product->gallery)
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        @foreach(is_string($product->gallery) ? json_decode($product->gallery, true) : $product->gallery as $img)
                            <img src="{{ asset('storage/'.$img) }}" style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
                        @endforeach
                    </div>
                @endif
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                <div class="small text-muted mt-1">Upload new images to replace the existing gallery.</div>
            </div>

            <div class="admin-form-card">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Publish Settings</h6>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" {{ $product->status ? 'checked' : '' }}>
                    <label class="form-check-label fw-600" for="statusSwitch">Published (Active)</label>
                </div>
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="featured" id="featuredSwitch" {{ $product->featured ? 'checked' : '' }}>
                    <label class="form-check-label fw-600" for="featuredSwitch">⭐ Featured Product</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-check-lg me-2"></i>Update Product
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
