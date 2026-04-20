@extends('layouts.app')

@section('title', 'Shop All Shoes')
@section('meta_description', 'Browse our complete collection of shoes. Filter by category, price, size, and color.')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h1 class="fw-800 mb-1" style="font-size:1.8rem;">
                {{ isset($category) ? $category->name : 'All Shoes' }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ isset($category) ? $category->name : 'Shop' }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small">{{ $products->total() }} products</span>
            <select onchange="window.location=this.value" class="form-select form-select-sm" style="width:auto;">
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"   {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>Latest</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}"  {{ request('sort') === 'name_asc'   ? 'selected' : '' }}>Name A-Z</option>
            </select>
        </div>
    </div>

    <div class="row g-4">
        <!-- ====== FILTER SIDEBAR ====== -->
        <div class="col-lg-3">
            <div class="filter-card">
                <form method="GET" action="{{ route('shop.index') }}" id="filterForm">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="filter-title mb-0"><i class="bi bi-funnel me-2 text-primary"></i>Filters</h6>
                        <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill" style="font-size:0.75rem;">Reset</a>
                    </div>

                    <!-- Search -->
                    <div class="mb-4">
                        <label class="filter-title">Search</label>
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="Search products..." value="{{ request('search') }}">
                    </div>

                    <!-- Categories -->
                    <div class="mb-4">
                        <label class="filter-title">Categories</label>
                        @foreach($categories as $cat)
                        <div class="filter-option">
                            <input type="radio" name="category" value="{{ $cat->slug }}"
                                   id="cat_{{ $cat->id }}"
                                   {{ request('category') === $cat->slug ? 'checked' : '' }}>
                            <label for="cat_{{ $cat->id }}" class="small fw-500 mb-0" style="cursor:pointer;">
                                {{ $cat->name }}
                                <span class="text-muted">({{ $cat->products_count }})</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Price Range -->
                    <div class="mb-4">
                        <label class="filter-title">Max Price: <span id="priceValue">₹{{ request('max_price', 10000) }}</span></label>
                        <input type="range" class="form-range" id="priceRange" name="max_price"
                               min="100" max="10000" step="100" value="{{ request('max_price', 10000) }}">
                        <div class="d-flex justify-content-between small text-muted">
                            <span>₹100</span><span>₹10,000</span>
                        </div>
                    </div>

                    <!-- Sizes -->
                    <div class="mb-4">
                        <label class="filter-title">Size</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($allSizes as $size)
                            <div>
                                <input type="radio" name="size" value="{{ $size }}" id="size_{{ $size }}"
                                       class="d-none" {{ request('size') === $size ? 'checked' : '' }}>
                                <label for="size_{{ $size }}"
                                       class="size-btn {{ request('size') === $size ? 'active' : '' }}">
                                    {{ $size }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Colors -->
                    <div class="mb-4">
                        <label class="filter-title">Color</label>
                        <div class="d-flex flex-wrap gap-2">
                            @php $colorMap = ['Black'=>'#000','White'=>'#f0f0f0','Red'=>'#ef4444','Blue'=>'#3b82f6','Brown'=>'#92400e','Grey'=>'#6b7280','Green'=>'#10b981']; @endphp
                            @foreach($allColors as $color)
                            <div>
                                <input type="radio" name="color" value="{{ $color }}" id="color_{{ $color }}"
                                       class="d-none" {{ request('color') === $color ? 'checked' : '' }}>
                                <label for="color_{{ $color }}"
                                       class="color-btn {{ request('color') === $color ? 'active' : '' }}"
                                       style="background: {{ $colorMap[$color] ?? '#ccc' }}; border: 2px solid {{ request('color') === $color ? '#6C3AFF' : '#ddd' }};"
                                       title="{{ $color }}"></label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i>Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- ====== PRODUCTS GRID ====== -->
        <div class="col-lg-9">
            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                    <h5 class="fw-700">No products found</h5>
                    <p class="text-muted">Try adjusting your filters or <a href="{{ route('shop.index') }}">clear all filters</a>.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-6 col-md-4">
                        @include('components.product-card', ['product' => $product])
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-submit on radio change (size, color, category)
$('[name="category"], [name="size"], [name="color"]').on('change', function () {
    $(this).closest('form').submit();
});
</script>
@endsection
