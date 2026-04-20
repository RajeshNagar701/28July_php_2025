@extends('layouts.app')

@section('title', 'Premium Shoes – Shop Online')
@section('meta_description', 'Shop the latest and most stylish shoes at ShoeStore. Sneakers, boots, sandals and more.')

@section('content')

{{-- ====== HERO SECTION ====== --}}
<section class="hero-section position-relative border-bottom" style="background: url('{{ asset('storage/banners/hero_bg.jpg') }}') center/cover no-repeat; padding: 120px 0;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(15,15,26,0.95) 0%, rgba(15,15,26,0.7) 50%, rgba(15,15,26,0.4) 100%);"></div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-8 hero-content">
                <div class="hero-badge animate__animated animate__fadeInDown bg-primary text-white border-0 shadow" style="opacity:0.9;">
                    🔥 New Collection 2025
                </div>
                <h1 class="hero-title animate__animated animate__fadeInUp text-white" style="text-shadow: 0 4px 15px rgba(0,0,0,0.5);">
                    Step Into Your <span class="text-primary">Best</span> Style
                </h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s text-light opacity-75 fs-5">
                    Discover premium quality shoes for every occasion. From casual to formal — we've got your feet covered.
                </p>
                <div class="d-flex gap-3 flex-wrap animate__animated animate__fadeInUp animate__delay-2s mt-4">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-700 shadow-lg border-0" style="background: #6C3AFF;">
                        <i class="bi bi-bag-fill me-2"></i>Shop Now
                    </a>
                    <a href="{{ route('shop.index') }}?featured=1" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-700">
                        <i class="bi bi-star me-2"></i>Featured
                    </a>
                </div>
                <!-- Stats -->
                <div class="d-flex gap-4 mt-5 pt-3">
                    <div class="text-white">
                        <div class="fw-800 fs-3">5K+</div>
                        <div class="opacity-75 small">Products</div>
                    </div>
                    <div class="vr bg-light opacity-25"></div>
                    <div class="text-white">
                        <div class="fw-800 fs-3">50K+</div>
                        <div class="opacity-75 small">Customers</div>
                    </div>
                    <div class="vr bg-light opacity-25"></div>
                    <div class="text-white">
                        <div class="fw-800 fs-3">4.9★</div>
                        <div class="opacity-75 small text-warning"><i class="bi bi-star-fill"></i> Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====== FEATURES STRIP ====== --}}
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row text-center g-3">
            @foreach([
                ['bi-truck', 'Free Shipping', 'On orders over ₹999'],
                ['bi-arrow-counterclockwise', 'Easy Returns', '30-day return policy'],
                ['bi-shield-check', '100% Authentic', 'Genuine products only'],
                ['bi-headset', '24/7 Support', 'We\'re always here'],
            ] as $feat)
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center gap-3 justify-content-center">
                    <div class="feat-icon">
                        <i class="bi {{ $feat[0] }} fs-4 text-primary"></i>
                    </div>
                    <div class="text-start">
                        <div class="fw-700 small">{{ $feat[1] }}</div>
                        <div class="text-muted" style="font-size:0.78rem">{{ $feat[2] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ====== CATEGORIES ====== --}}
@if($categories->isNotEmpty())
<section class="section-wrapper">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Shop by Category</h2>
            <p class="section-subtitle">Find the perfect pair for every occasion</p>
            <div class="title-line mx-auto"></div>
        </div>
        <div class="row g-3">
            @foreach($categories as $cat)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('shop.category', $cat->slug) }}" class="text-decoration-none">
                    <div class="category-card">
                        @if($cat->image)
                            <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=400&q=70" alt="{{ $cat->name }}">
                        @endif
                        <div class="cat-overlay">
                            <div>
                                <div class="cat-name">{{ $cat->name }}</div>
                                <div class="cat-count">{{ $cat->products_count }} items</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====== FEATURED PRODUCTS ====== --}}
@if($featuredProducts->isNotEmpty())
<section class="section-wrapper bg-light">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h2 class="section-title mb-1">Featured Products</h2>
                <p class="section-subtitle">Handpicked premium picks for you</p>
            </div>
            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">View All <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====== BANNER ====== --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="promo-banner rounded-4 p-4 d-flex align-items-center"
                     style="background: linear-gradient(135deg, #6C3AFF, #9b6cff); min-height: 180px; overflow: hidden; position: relative;">
                    <div style="position:relative; z-index:2;">
                        <div class="text-white opacity-75 small fw-600 mb-1">UP TO 40% OFF</div>
                        <h3 class="fw-800 text-white mb-2">Men's Collection</h3>
                        <a href="{{ route('shop.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-600">Shop Now</a>
                    </div>
                    <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=300&q=80" alt="Men's Shoes" 
                         style="position:absolute; right:-30px; bottom:-20px; height:200px; object-fit:contain; transform: rotate(-15deg); opacity: 0.9; border-radius: 20px;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="promo-banner rounded-4 p-4 d-flex align-items-center"
                     style="background: linear-gradient(135deg, #FF6B35, #ff9068); min-height: 180px; overflow: hidden; position: relative;">
                    <div style="position:relative; z-index:2;">
                        <div class="text-white opacity-75 small fw-600 mb-1">NEW ARRIVALS</div>
                        <h3 class="fw-800 text-white mb-2">Women's Picks</h3>
                        <a href="{{ route('shop.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-600">Shop Now</a>
                    </div>
                    <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=300&q=80" alt="Women's Shoes" 
                         style="position:absolute; right:-10px; bottom:-30px; height:200px; object-fit:contain; transform: rotate(-5deg); opacity: 0.95; mix-blend-mode: multiply;">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====== NEW ARRIVALS ====== --}}
@if($newArrivals->isNotEmpty())
<section class="section-wrapper">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h2 class="section-title mb-1">New Arrivals</h2>
                <p class="section-subtitle">Fresh styles just landed</p>
            </div>
            <a href="{{ route('shop.index') }}?sort=latest" class="btn btn-outline-primary">View All <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="row g-4">
            @foreach($newArrivals as $product)
            <div class="col-6 col-md-4 col-lg-3">
                @include('components.product-card', ['product' => $product, 'badge' => 'NEW'])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ====== NEWSLETTER ====== --}}
<section class="py-5" style="background: linear-gradient(135deg, #0f0f1a, #1a1a3e);">
    <div class="container text-center">
        <h3 class="fw-800 text-white mb-2">Get 10% Off Your First Order</h3>
        <p class="text-white opacity-75 mb-4">Subscribe to our newsletter for exclusive deals and new arrivals.</p>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="input-group input-group-lg">
                    <input type="email" class="form-control rounded-pill-start border-0" placeholder="Enter your email">
                    <button class="btn btn-primary rounded-pill-end px-4">Subscribe</button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
