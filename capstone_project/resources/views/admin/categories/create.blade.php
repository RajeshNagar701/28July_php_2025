@extends('layouts.admin')
@section('title', 'Add Category')

@section('content')
<div class="page-header">
    <div>
        <h2>Add Category</h2>
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active">Add</li>
        </ol>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-form-card">
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required placeholder="e.g. Running Shoes">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                               accept="image/*" id="categoryImageInput">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="imagePreview" class="mt-2 d-none">
                            <img id="previewImg" src="" style="max-height:120px; border-radius:10px;" alt="Preview">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="SEO title">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2" placeholder="SEO description">{{ old('meta_description') }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" checked>
                            <label class="form-check-label fw-600" for="statusSwitch">Active</label>
                        </div>
                    </div>
                    <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-plus-lg me-2"></i>Create Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$('#categoryImageInput').on('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            $('#previewImg').attr('src', e.target.result);
            $('#imagePreview').removeClass('d-none');
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
