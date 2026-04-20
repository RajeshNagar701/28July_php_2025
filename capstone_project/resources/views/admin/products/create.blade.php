@extends('layouts.admin')
@section('title', 'Add Product')

@section('content')
<div class="page-header">
    <div>
        <h2>Add Product</h2>
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">Add</li>
        </ol>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <!-- LEFT COLUMN -->
        <div class="col-lg-8">
            <div class="admin-form-card mb-4">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Basic Information</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required placeholder="e.g. Nike Air Max 270">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Selling Price (₹) *</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price') }}" step="0.01" min="0" required placeholder="999">
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Original Price (₹)</label>
                        <input type="number" name="original_price" class="form-control"
                               value="{{ old('original_price') }}" step="0.01" min="0" placeholder="1299">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Product description...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="admin-form-card mb-4">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Variants & Inventory</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}" min="0" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Available Sizes <small class="text-muted">(comma separated)</small></label>
                        <input type="text" name="sizes" class="form-control" value="{{ old('sizes') }}" placeholder="6,7,8,9,10,11">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Available Colors <small class="text-muted">(comma separated)</small></label>
                        <input type="text" name="colors" class="form-control" value="{{ old('colors') }}" placeholder="Black,White,Red,Blue">
                    </div>
                </div>
            </div>

            <div class="admin-form-card">
                <h6 class="fw-700 mb-4 border-bottom pb-3">SEO Settings</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="SEO title">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2" placeholder="SEO description...">{{ old('meta_description') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Image Alt Tag</label>
                        <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt') }}" placeholder="Descriptive alt text for main image">
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">
            <div class="admin-form-card mb-4">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Main Image *</h6>
                <div class="text-center">
                    <div id="mainImagePreview" class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3 overflow-hidden"
                         style="height:200px;">
                        <i class="bi bi-image text-muted fs-1" id="mainImgPlaceholder"></i>
                        <img id="mainImgPreview" src="" class="w-100 h-100 d-none" style="object-fit:cover;" alt="Preview">
                    </div>
                    <input type="file" name="image" id="mainImageInput" class="form-control @error('image') is-invalid @enderror"
                           accept="image/*" required>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="admin-form-card mb-4">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Gallery Images</h6>
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                <div class="small text-muted mt-1">Upload multiple images for gallery</div>
            </div>

            <div class="admin-form-card">
                <h6 class="fw-700 mb-4 border-bottom pb-3">Publish Settings</h6>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" checked>
                    <label class="form-check-label fw-600" for="statusSwitch">Published (Active)</label>
                </div>
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="featured" id="featuredSwitch">
                    <label class="form-check-label fw-600" for="featuredSwitch">⭐ Featured Product</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="bi bi-plus-lg me-2"></i>Create Product
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
$('#mainImageInput').on('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            $('#mainImgPlaceholder').addClass('d-none');
            $('#mainImgPreview').attr('src', e.target.result).removeClass('d-none');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
