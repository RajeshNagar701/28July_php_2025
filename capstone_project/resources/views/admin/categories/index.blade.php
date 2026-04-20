@extends('layouts.admin')
@section('title', 'Categories')

@section('content')
<div class="page-header">
    <div>
        <h2>Categories</h2>
        <ol class="breadcrumb small mb-0"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Categories</li></ol>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Category
    </a>
</div>

<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h5>All Categories ({{ $categories->total() }})</h5>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th><th>Image</th><th>Name</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td class="text-muted small">{{ $cat->id }}</td>
                <td>
                    @if($cat->image)
                        <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" class="product-thumb">
                    @else
                        <div class="product-thumb d-flex align-items-center justify-content-center bg-light text-muted rounded">
                            <i class="bi bi-image"></i>
                        </div>
                    @endif
                </td>
                <td class="fw-700">{{ $cat->name }}</td>
                <td><code class="small">{{ $cat->slug }}</code></td>
                <td><span class="badge bg-primary rounded-pill">{{ $cat->products_count }}</span></td>
                <td>
                    <span class="status-badge {{ $cat->status ? 'status-delivered' : 'status-cancelled' }}">
                        {{ $cat->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger rounded-pill btn-delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No categories found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3 d-flex justify-content-center">{{ $categories->links() }}</div>
</div>
@endsection
