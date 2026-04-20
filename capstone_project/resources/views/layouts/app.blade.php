<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShoeStore') | ShoeStore - Premium Footwear</title>
    <meta name="description" content="@yield('meta_description', 'Shop the best shoes online at ShoeStore. Premium quality footwear for men, women and kids.')">
    <meta name="keywords" content="@yield('meta_keywords', 'shoes, footwear, sneakers, boots, sandals, online shopping')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body>

<!-- Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="liveToast" class="toast align-items-center border-0 shadow-lg" role="alert">
        <div class="d-flex">
            <div class="toast-body fw-semibold" id="toastMessage">Message here</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-800" href="{{ route('home') }}">
            <i class="bi bi-bag-heart-fill me-1"></i>ShoeStore
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <!-- Nav Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('shop*') ? 'active' : '' }}" href="{{ route('shop.index') }}">Shop</a>
                </li>
                <!-- Categories Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Categories</a>
                    <ul class="dropdown-menu shadow border-0">
                        @foreach(\App\Models\Category::active()->take(8)->get() as $cat)
                            <li>
                                <a class="dropdown-item" href="{{ route('shop.category', $cat->slug) }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- Search Bar -->
            <div class="search-wrapper me-3 position-relative">
                <div class="input-group">
                    <input type="text" id="liveSearch" class="form-control search-input"
                        placeholder="Search shoes..." autocomplete="off">
                    <button class="btn btn-search" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <!-- Live Search Results -->
                <div id="searchResults" class="search-results shadow d-none"></div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-2">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="btn btn-icon position-relative" title="Cart">
                    <i class="bi bi-bag fs-5"></i>
                    <span class="badge cart-badge" id="cartBadge">0</span>
                </a>

                @auth
                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" class="btn btn-icon" title="Wishlist">
                        <i class="bi bi-heart fs-5"></i>
                    </a>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li class="dropdown-header fw-semibold">{{ auth()->user()->name }}</li>
                            <li><hr class="dropdown-divider"></li>
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2"></i>Admin Panel
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                <i class="bi bi-box me-2"></i>My Orders
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('wishlist.index') }}">
                                <i class="bi bi-heart me-2"></i>Wishlist
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-pill px-3">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
@if(session('success') || session('error') || session('info'))
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>
@endif

<!-- Main Content -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer mt-5">
    <div class="container">
        <div class="row g-4 py-5">
            <div class="col-lg-4">
                <h5 class="fw-800 mb-3"><i class="bi bi-bag-heart-fill me-2"></i>ShoeStore</h5>
                <p class="text-muted small">Your one-stop destination for premium quality footwear. We bring the latest trends right to your doorstep.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="footer-social"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="footer-social"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <h6 class="fw-700 mb-3">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    @auth
                        <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-lg-3 col-sm-6">
                <h6 class="fw-700 mb-3">Categories</h6>
                <ul class="list-unstyled footer-links">
                    @foreach(\App\Models\Category::active()->take(5)->get() as $cat)
                        <li><a href="{{ route('shop.category', $cat->slug) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="fw-700 mb-3">Contact Us</h6>
                <ul class="list-unstyled footer-links small">
                    <li><i class="bi bi-geo-alt me-2 text-primary"></i>123 Shoe Lane, Mumbai, India</li>
                    <li><i class="bi bi-telephone me-2 text-primary"></i>+91 98765 43210</li>
                    <li><i class="bi bi-envelope me-2 text-primary"></i>hello@shoestore.in</li>
                </ul>
                <div class="mt-3">
                    <img src="https://img.icons8.com/color/48/000000/visa.png" height="28" class="me-1" alt="Visa">
                    <img src="https://img.icons8.com/color/48/000000/mastercard.png" height="28" class="me-1" alt="Mastercard">
                    <img src="https://img.icons8.com/color/48/000000/upi.png" height="28" alt="UPI">
                </div>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center py-3 small text-muted">
            &copy; {{ date('Y') }} ShoeStore. All rights reserved. Built with ❤️ in India.
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom Frontend JS -->
<script src="{{ asset('js/frontend.js') }}"></script>

<script>
// Global AJAX setup — CSRF token for all requests
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('liveToast');
    const toastMsg = document.getElementById('toastMessage');
    toastMsg.textContent = message;
    toast.className = `toast align-items-center border-0 shadow-lg text-white bg-${type}`;
    const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
    bsToast.show();
}

// Update cart badge on page load
$(document).ready(function () {
    $.get('{{ route("cart.count") }}', function (res) {
        const count = res.count || 0;
        $('#cartBadge').text(count).toggleClass('d-none', count === 0);
    });
});
</script>

@include('components.chatbot')
@yield('scripts')
</body>
</html>
