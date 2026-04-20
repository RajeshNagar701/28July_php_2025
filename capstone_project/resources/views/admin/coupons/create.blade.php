@extends('layouts.admin')
@section('title', 'Create Coupon')

@section('content')
<div class="page-header">
    <div>
        <h2>Create Coupon</h2>
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </div>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="admin-form-card">
            <form method="POST" action="{{ route('admin.coupons.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Coupon Code *</label>
                        <input type="text" name="code" class="form-control text-uppercase fw-700 @error('code') is-invalid @enderror"
                               value="{{ old('code') }}" required placeholder="SAVE20" style="letter-spacing:2px;">
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Discount *</label>
                        <input type="number" name="discount" class="form-control @error('discount') is-invalid @enderror"
                               value="{{ old('discount') }}" step="0.01" min="0" required placeholder="20">
                        @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Type *</label>
                        <select name="type" class="form-select" required>
                            <option value="percent" {{ old('type') === 'percent' ? 'selected' : '' }}>Percent (%)</option>
                            <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed (₹)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Min. Order Amount (₹)</label>
                        <input type="number" name="min_order" class="form-control" value="{{ old('min_order', 0) }}" min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Max Uses</label>
                        <input type="number" name="max_uses" class="form-control" value="{{ old('max_uses') }}" min="1" placeholder="Leave blank for unlimited">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Valid From</label>
                        <input type="date" name="valid_from" class="form-control" value="{{ old('valid_from') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Valid Until</label>
                        <input type="date" name="valid_until" class="form-control" value="{{ old('valid_until') }}">
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" checked>
                            <label class="form-check-label fw-600" for="statusSwitch">Active</label>
                        </div>
                    </div>
                    <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="bi bi-ticket-perforated me-2"></i>Create Coupon
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
