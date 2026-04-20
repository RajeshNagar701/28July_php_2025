@extends('layouts.app')
@section('title', $product->meta_title ?? $product->name)
@section('meta_description', $product->meta_description ?? Str::limit($product->description, 160))

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- ====== PRODUCT GALLERY ====== -->
        <div class="col-lg-6">
            <div class="sticky-top" style="top: 90px;">
                <div class="product-gallery mb-3">
                    <img id="mainProductImage"
                         src="{{ $product->image ? asset('storage/'.$product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80' }}"
                         alt="{{ $product->image_alt ?? $product->name }}"
                         class="w-100 rounded-4 shadow-sm" style="height:420px; object-fit:cover;">
                </div>
                <!-- Thumbnails -->
                @if($product->gallery)
                <div class="d-flex gap-2 flex-wrap">
                    <img class="thumbnail-img active"
                         src="{{ asset('storage/'.$product->image) }}"
                         data-src="{{ asset('storage/'.$product->image) }}"
                         alt="{{ $product->name }}">
                    @foreach($product->gallery as $img)
                    <img class="thumbnail-img"
                         src="{{ asset('storage/'.$img) }}"
                         data-src="{{ asset('storage/'.$img) }}"
                         alt="Gallery image">
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- ====== PRODUCT INFO ====== -->
        <div class="col-lg-6">
            <!-- Category & Name -->
            <a href="{{ route('shop.category', $product->category->slug) }}"
               class="text-primary text-decoration-none small fw-600 text-uppercase">
               {{ $product->category->name }}
            </a>
            <h1 class="fw-800 mt-1 mb-2" style="font-size:1.9rem; line-height:1.2;">{{ $product->name }}</h1>

            <!-- Rating -->
            <div class="d-flex align-items-center gap-2 mb-3">
                <div class="star-rating">
                    @for($i=1; $i<=5; $i++)
                        <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                    @endfor
                </div>
                <span class="small text-muted fw-600">{{ number_format($avgRating, 1) }} ({{ $reviews->count() }} reviews)</span>
            </div>

            <!-- Price -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <span class="fw-800 text-primary" style="font-size:2rem;">₹{{ number_format($product->price, 2) }}</span>
                @if($product->hasDiscount())
                    <span class="text-muted text-decoration-line-through fs-5">₹{{ number_format($product->original_price, 2) }}</span>
                    <span class="badge bg-danger rounded-pill px-3">{{ $product->discount_percent }}% OFF</span>
                @endif
            </div>

            <!-- Description -->
            @if($product->description)
            <p class="text-muted mb-4 lh-lg">{{ $product->description }}</p>
            @endif

            <!-- Stock Status -->
            <div class="mb-3">
                @if($product->quantity > 0)
                    <span class="badge bg-success rounded-pill px-3 py-2">
                        <i class="bi bi-check-circle me-1"></i>In Stock ({{ $product->quantity }} available)
                    </span>
                @else
                    <span class="badge bg-danger rounded-pill px-3 py-2">
                        <i class="bi bi-x-circle me-1"></i>Out of Stock
                    </span>
                @endif
            </div>

            <!-- Size Selection -->
            @if($product->sizes)
            <div class="mb-4">
                <label class="fw-700 d-block mb-2">Size: <span id="selectedSize" class="text-primary">Select</span></label>
                <input type="hidden" name="size" id="selectedSizeInput">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($product->sizes_array as $size)
                    <button type="button" class="size-btn" data-size="{{ $size }}">{{ $size }}</button>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Color Selection -->
            @if($product->colors)
            <div class="mb-4">
                <label class="fw-700 d-block mb-2">Color: <span id="selectedColor" class="text-primary">Select</span></label>
                <input type="hidden" name="color" id="selectedColorInput">
                @php $colorMap = ['Black'=>'#000','White'=>'#f0f0f0','Red'=>'#ef4444','Blue'=>'#3b82f6','Brown'=>'#92400e','Grey'=>'#6b7280','Green'=>'#10b981']; @endphp
                <div class="d-flex gap-2">
                    @foreach($product->colors_array as $color)
                    <button type="button" class="color-btn"
                            style="background:{{ $colorMap[$color] ?? '#ccc' }}; border-color:#ddd;"
                            data-color="{{ $color }}"
                            title="{{ $color }}"></button>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quantity -->
            <div class="mb-4">
                <label class="fw-700 d-block mb-2">Quantity</label>
                <div class="qty-control" style="max-width: 140px;">
                    <button class="qty-btn" id="qtyDecrease">−</button>
                    <input type="number" id="qtyInput" class="qty-input" value="1" min="1" max="{{ $product->quantity }}">
                    <button class="qty-btn" id="qtyIncrease">+</button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-3 flex-wrap mb-4">
                @if($product->quantity > 0)
                    <button class="btn btn-primary flex-grow-1 btn-add-cart" data-product-id="{{ $product->id }}">
                        <i class="bi bi-bag-plus me-2"></i>Add to Cart
                    </button>
                @endif
                @auth
                    <button class="btn {{ $inWishlist ? 'btn-danger' : 'btn-outline-danger' }} px-3 btn-wishlist"
                            data-product-id="{{ $product->id }}"
                            title="{{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                        <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                    </button>
                @endauth
            </div>

            <!-- Features -->
            <div class="d-flex gap-4 py-3 border-top border-bottom flex-wrap">
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-truck text-primary"></i> Free Delivery
                </div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-arrow-counterclockwise text-primary"></i> 30-Day Return
                </div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-shield-check text-primary"></i> Authentic
                </div>
            </div>
        </div>
    </div>

    <!-- ====== REVIEWS SECTION ====== -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-800 mb-4">Customer Reviews</h3>
        </div>
        <div class="col-lg-4">
            <!-- Rating Overview -->
            <div class="text-center p-4 bg-white rounded-4 shadow-sm mb-4">
                <div class="display-4 fw-800 text-primary">{{ number_format($avgRating, 1) }}</div>
                <div class="star-rating fs-4 mb-2">
                    @for($i=1; $i<=5; $i++)
                        <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                    @endfor
                </div>
                <p class="text-muted small">Based on {{ $reviews->count() }} reviews</p>
                <!-- Rating bars -->
                @for($r=5; $r>=1; $r--)
                @php $cnt = $ratingCounts[$r] ?? 0; $pct = $reviews->count() ? ($cnt/$reviews->count())*100 : 0; @endphp
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="small text-muted" style="width:14px;">{{ $r }}</span>
                    <i class="bi bi-star-fill text-warning small"></i>
                    <div class="progress flex-grow-1" style="height:8px;">
                        <div class="progress-bar bg-warning" style="width:{{ $pct }}%"></div>
                    </div>
                    <span class="small text-muted" style="width:20px;">{{ $cnt }}</span>
                </div>
                @endfor
            </div>

            <!-- Write Review -->
            @auth
            @if(!$userReview)
            <div class="p-4 bg-white rounded-4 shadow-sm">
                <h6 class="fw-700 mb-3">Write a Review</h6>
                <form action="{{ route('shop.review', $product->slug) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="star-rating-input d-flex gap-2">
                            @for($r=5; $r>=1; $r--)
                            <div>
                                <input type="radio" name="rating" value="{{ $r }}" id="star{{ $r }}" class="d-none">
                                <label for="star{{ $r }}" class="fs-4" style="cursor:pointer; color:#ddd;"
                                       onmouseover="hoverStar({{ $r }})"
                                       onmouseout="resetStar()">★</label>
                            </div>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comment (optional)</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit Review</button>
                </form>
            </div>
            @else
            <div class="alert alert-success small rounded-3">
                <i class="bi bi-check-circle me-1"></i>You've already reviewed this product.
            </div>
            @endif
            @else
            <div class="alert alert-info small rounded-3">
                <a href="{{ route('login') }}">Login</a> to write a review.
            </div>
            @endauth
        </div>

        <div class="col-lg-8">
            @if($reviews->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-chat-left-text fs-1 d-block mb-2"></i>
                    No reviews yet. Be the first to review!
                </div>
            @else
                @foreach($reviews as $review)
                <div class="bg-white rounded-4 shadow-sm p-4 mb-3">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:42px; height:42px; background: linear-gradient(135deg, #6C3AFF, #FF6B35); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:800; flex-shrink:0;">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <strong>{{ $review->user->name }}</strong>
                                <div class="star-rating small">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-muted small">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if($review->comment)
                            <p class="mb-0 mt-2 text-muted">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- ====== RELATED PRODUCTS ====== -->
    @if($relatedProducts->isNotEmpty())
    <div class="mt-5">
        <h3 class="fw-800 mb-4">You May Also Like</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-6 col-md-3">
                @include('components.product-card', ['product' => $related])
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Update size/color display labels
$(document).on('click', '.size-btn', function () {
    $('#selectedSize').text($(this).data('size'));
    $('#selectedSizeInput').val($(this).data('size'));
});
$(document).on('click', '.color-btn', function () {
    $('#selectedColor').text($(this).data('color'));
    $('#selectedColorInput').val($(this).data('color'));
});
</script>
@endsection
