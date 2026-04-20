@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-lg w-100 animate__animated animate__fadeInUp" style="max-width: 1000px; border-radius: 1.5rem; overflow: hidden;">
        <div class="row g-0 flex-row-reverse">
            <!-- Right Image Side -->
            <div class="col-md-6 d-none d-md-block position-relative" style="background: url('https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=800&q=80') center/cover no-repeat;">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.8) 100%);"></div>
                <div class="position-absolute bottom-0 start-0 w-100 p-5 text-white text-end">
                    <h2 class="fw-800 display-6">Join the Club</h2>
                    <p class="opacity-75 fs-6 mb-0">Create an account to gain access to member-only drops, faster checkout, and automated AI assistance.</p>
                </div>
            </div>

            <!-- Left Form Side -->
            <div class="col-md-6 bg-white p-5 p-lg-5 p-md-4">
                <div class="mb-4 text-center text-md-start">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-plus text-primary fs-3"></i>
                    </div>
                    <h3 class="fw-800 text-dark mb-1">Create Account</h3>
                    <p class="text-muted small">Fill in your details below to get started.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="form-floating mb-3">
                        <input id="name" type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="John Doe">
                        <label for="name" class="text-muted"><i class="bi bi-person me-2"></i>Full Name</label>
                        @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input id="email" type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                        <label for="email" class="text-muted"><i class="bi bi-envelope me-2"></i>Email Address</label>
                        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input id="phone" type="text" class="form-control rounded-3 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                        <label for="phone" class="text-muted"><i class="bi bi-telephone me-2"></i>Phone Number (Optional)</label>
                        @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="form-floating">
                                <input id="password" type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                <label for="password" class="text-muted"><i class="bi bi-lock me-2"></i>Password</label>
                                @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating">
                                <input id="password-confirm" type="password" class="form-control rounded-3" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm">
                                <label for="password-confirm" class="text-muted"><i class="bi bi-check-circle me-2"></i>Confirm</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-700 rounded-3 shadow-sm mb-4">
                        Register Account <i class="bi bi-chevron-right ms-2"></i>
                    </button>
                    
                    <div class="text-center small text-muted">
                        Already a member? 
                        <a href="{{ route('login') }}" class="fw-700 text-primary text-decoration-none position-relative custom-link">
                            Log in here
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
</style>
@endsection
