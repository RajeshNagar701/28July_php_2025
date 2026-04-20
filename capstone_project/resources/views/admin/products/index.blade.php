@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="page-header">
    <div>
        <h2>Products</h2>
        <ol class="breadcrumb small mb-0"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Products</li></ol>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Product
    </a>
</div>

<!-- Search/Filter Bar -->
<div class="admin-form-card mb-4">
    <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Product name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h5>All Products ({{ $products->total() }})</h5>
    </div>
    <table class="table">
        <thead>
            <tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=80&q=70' }}"
                         class="product-thumb" alt="{{ $product->name }}">
                </td>
                <td>
                    <div class="fw-700">{{ Str::limit($product->name, 35) }}</div>
                    @if($product->featured)
                        <span class="badge" style="background:#fef3c7; color:#d97706; font-size:0.7rem;">⭐ Featured</span>
                    @endif
                </td>
                <td class="small text-muted">{{ $product->category->name ?? '—' }}</td>
                <td>
                    <div class="fw-700 text-primary">₹{{ number_format($product->price, 2) }}</div>
                    @if($product->hasDiscount())
                        <small class="text-muted text-decoration-line-through">₹{{ number_format($product->original_price, 2) }}</small>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $product->quantity > 10 ? 'bg-success' : ($product->quantity > 0 ? 'bg-warning text-dark' : 'bg-danger') }} rounded-pill">
                        {{ $product->quantity }}
                    </span>
                </td>
                <td>
                    <span class="status-badge {{ $product->status ? 'status-delivered' : 'status-cancelled' }}">
                        {{ $product->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger rounded-pill btn-delete" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3 d-flex justify-content-center">{{ $products->links() }}</div>
</div>
@endsection
