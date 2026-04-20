{{-- Reusable Product Card Component --}}
@php
    $badge = $badge ?? ($product->hasDiscount() ? 'SALE' : ($product->featured ? 'HOT' : null));
    $inWishlist = auth()->check()
        ? $product->wishlists()->where('user_id', auth()->id())->exists()
        : false;
@endphp

<div class="product-card h-100">
    <div class="card-img-wrapper">
        <a href="{{ route('shop.show', $product->slug) }}">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=70' }}"
                 alt="{{ $product->image_alt ?? $product->name }}"
                 loading="lazy">
        </a>

        {{-- Badge --}}
        @if($badge)
            <span class="product-badge {{ $badge === 'SALE' ? 'badge-sale' : ($badge === 'NEW' ? 'badge-new' : 'badge-hot') }}">
                {{ $badge }}
            </span>
        @endif

        {{-- Quick Actions --}}
        <div class="card-quick-actions">
            {{-- Wishlist --}}
            <button class="quick-action-btn btn-wishlist {{ $inWishlist ? 'active' : '' }}"
                    data-product-id="{{ $product->id }}"
                    title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }}"></i>
            </button>
            {{-- Quick View (links to detail) --}}
            <a href="{{ route('shop.show', $product->slug) }}" class="quick-action-btn" title="View Details">
                <i class="bi bi-eye"></i>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="product-category">{{ $product->category->name ?? '' }}</div>
        <div class="product-name">
            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
        </div>

        {{-- Rating --}}
        @php $rating = round($product->average_rating); @endphp
        <div class="star-rating mb-2">
            @for($i = 1; $i <= 5; $i++)
                <i class="bi {{ $i <= $rating ? 'bi-star-fill' : 'bi-star' }}"></i>
            @endfor
            <span class="text-muted ms-1" style="font-size:0.75rem;">({{ $product->reviews()->count() }})</span>
        </div>

        {{-- Price --}}
        <div class="product-price d-flex align-items-center gap-2 flex-wrap mb-2">
            <span class="current-price">₹{{ number_format($product->price, 2) }}</span>
            @if($product->hasDiscount())
                <span class="old-price">₹{{ number_format($product->original_price, 2) }}</span>
                <span class="discount-badge">-{{ $product->discount_percent }}%</span>
            @endif
        </div>

        {{-- Add to Cart --}}
        @if($product->quantity > 0)
            <button class="btn-add-cart btn-add-cart" data-product-id="{{ $product->id }}">
                <i class="bi bi-bag-plus me-1"></i>Add to Cart
            </button>
        @else
            <button class="btn-add-cart" disabled style="background: #ccc; cursor:not-allowed;">
                <i class="bi bi-x-circle me-1"></i>Out of Stock
            </button>
        @endif
    </div>
</div>
