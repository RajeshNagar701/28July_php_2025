@extends('layouts.admin')
@section('title', 'Edit Customer')

@section('content')
<div class="page-header">
    <div>
        <h2>Edit Customer Profile</h2>
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </div>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-form-card">
            <div class="text-center mb-4">
                <div style="width:80px;height:80px;background:linear-gradient(135deg,#6C3AFF,#FF6B35);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:1.8rem;margin: 0 auto 15px;">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <h5 class="fw-800 mb-0">{{ $customer->name }}</h5>
                <p class="text-muted small">ID: #{{ $customer->id }}</p>
            </div>

            <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-600">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label fw-600">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $customer->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-600">Phone Number</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $customer->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-600">User Role</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="customer" {{ old('role', $customer->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin" {{ old('role', $customer->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 pt-3">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-700">
                            <i class="bi bi-person-check me-2"></i>Update Customer Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
