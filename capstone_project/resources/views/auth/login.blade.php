@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-lg w-100 animate__animated animate__fadeInUp" style="max-width: 1000px; border-radius: 1.5rem; overflow: hidden;">
        <div class="row g-0">
            <!-- Left Image Side -->
            <div class="col-md-6 d-none d-md-block position-relative" style="background: url('https://images.unsplash.com/photo-1552346154-21d32810baa3?w=800&q=80') center/cover no-repeat;">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.8) 100%);"></div>
                <div class="position-absolute bottom-0 start-0 w-100 p-5 text-white">
                    <h2 class="fw-800 display-6">Welcome Back</h2>
                    <p class="opacity-75 fs-6 mb-0">Experience premium quality, exclusive releases, and high-performance footwear with ShoeStore.</p>
                </div>
            </div>

            <!-- Right Form Side -->
            <div class="col-md-6 bg-white p-5 p-lg-5 p-md-4">
                <div class="mb-5 text-center text-md-start mt-md-3">
                    <i class="bi bi-box-arrow-in-right text-primary mb-3 d-inline-block" style="font-size: 2.5rem;"></i>
                    <h3 class="fw-800 text-dark mb-1">Sign In</h3>
                    <p class="text-muted small">Access your orders, wishlist, and recommendations.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                        <label for="email" class="text-muted"><i class="bi bi-envelope me-2"></i>Email Address</label>
                        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        <label for="password" class="text-muted"><i class="bi bi-lock me-2"></i>Password</label>
                        @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input shadow-none cursor-pointer" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small user-select-none cursor-pointer" for="remember">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="small fw-600 text-decoration-none text-primary" href="{{ route('password.request') }}">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-700 rounded-3 shadow-sm mb-4">
                        Login to Account <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                    
                    <div class="text-center small text-muted mt-3 mb-2">
                        Don't have an account yet? 
                        <a href="{{ route('register') }}" class="fw-700 text-primary text-decoration-none position-relative custom-link">
                            Create an account
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-link::after {
        content: ''; position: absolute; width: 100%; transform: scaleX(0); height: 2px;
        bottom: -2px; left: 0; background-color: var(--bs-primary);
        transform-origin: bottom right; transition: transform 0.25s ease-out;
    }
    .custom-link:hover::after { transform: scaleX(1); transform-origin: bottom left; }
    .form-control:focus { border-color: var(--bs-primary); box-shadow: 0 0 0 0.25rem rgba(108, 58, 255, 0.15); }
    .cursor-pointer { cursor: pointer; }
</style>
@endsection
