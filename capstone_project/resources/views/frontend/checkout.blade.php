@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h1 class="fw-800 mb-1" style="font-size:1.8rem;">Checkout</h1>
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol>
    </nav>

    <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="row g-4">
            <!-- ====== LEFT: Shipping Details ====== -->
            <div class="col-lg-7">
                <div class="checkout-card">
                    <h5 class="fw-800 mb-4"><i class="bi bi-geo-alt text-primary me-2"></i>Shipping Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror"
                                   value="{{ old('shipping_name', $user->name) }}" required>
                            @error('shipping_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="shipping_email" class="form-control @error('shipping_email') is-invalid @enderror"
                                   value="{{ old('shipping_email', $user->email) }}" required>
                            @error('shipping_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone *</label>
                            <input type="text" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror"
                                   value="{{ old('shipping_phone', $user->phone) }}" required>
                            @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City *</label>
                            <input type="text" name="shipping_city" class="form-control @error('shipping_city') is-invalid @enderror"
                                   value="{{ old('shipping_city') }}" required>
                            @error('shipping_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address *</label>
                            <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                                      rows="2" required>{{ old('shipping_address', $user->address) }}</textarea>
                            @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ZIP / Pincode</label>
                            <input type="text" name="shipping_zip" class="form-control" value="{{ old('shipping_zip') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Order Notes</label>
                            <input type="text" name="notes" class="form-control" placeholder="Optional notes">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-card">
                    <h5 class="fw-800 mb-4"><i class="bi bi-credit-card text-primary me-2"></i>Payment Method</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="radio" name="payment_method" value="cod" id="pay_cod" class="d-none" checked>
                            <label for="pay_cod" class="payment-option w-100 p-3 rounded-3 border-2 border text-center fw-600"
                                   style="cursor:pointer; transition:all 0.2s;">
                                <i class="bi bi-cash-stack d-block fs-2 text-success mb-2"></i>
                                Cash on Delivery
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input type="radio" name="payment_method" value="online" id="pay_online" class="d-none">
                            <label for="pay_online" class="payment-option w-100 p-3 rounded-3 border-2 border text-center fw-600"
                                   style="cursor:pointer; transition:all 0.2s;">
                                <i class="bi bi-qr-code d-block fs-2 text-primary mb-2"></i>
                                Online Payment (Razorpay)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====== RIGHT: Order Summary ====== -->
            <div class="col-lg-5">
                <div class="cart-summary">
                    <h5 class="fw-800 mb-4"><i class="bi bi-bag-check text-primary me-2"></i>Order Summary</h5>

                    <!-- Items -->
                    <div class="mb-3" style="max-height:280px; overflow-y:auto;">
                        @foreach($cart->items as $item)
                        <div class="d-flex gap-3 align-items-center mb-3">
                            <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=80&q=70' }}"
                                 style="width:52px; height:52px; object-fit:cover; border-radius:10px; flex-shrink:0;" alt="{{ $item->product->name }}">
                            <div class="flex-grow-1">
                                <div class="fw-600 small">{{ $item->product->name }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">
                                    Qty: {{ $item->quantity }}
                                    @if($item->size) | Size: {{ $item->size }} @endif
                                    @if($item->color) | Color: {{ $item->color }} @endif
                                </div>
                            </div>
                            <div class="fw-700 small">₹{{ number_format($item->subtotal, 2) }}</div>
                        </div>
                        @endforeach
                    </div>
                    <hr>

                    <!-- Coupon -->
                    <div class="mb-3">
                        <label class="form-label fw-600 small">Have a coupon?</label>
                        <div class="input-group input-group-sm">
                            <input type="text" id="couponCode" class="form-control" placeholder="Enter coupon code">
                            <button class="btn btn-outline-primary" id="applyCouponBtn">Apply</button>
                        </div>
                        <div id="couponMessage" class="mt-2"></div>
                    </div>

                    <!-- Totals -->
                    <div class="summary-row">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-600">₹{{ number_format($cart->getTotal(), 2) }}</span>
                    </div>
                    <div class="summary-row" id="discountRow" style="{{ session('coupon') ? '' : 'display:none;' }}">
                        <span class="text-success">Discount</span>
                        <span class="fw-600 text-success" id="discountAmount">
                            {{ session('coupon') ? '- ₹'.number_format(session('coupon.discount'), 2) : '' }}
                        </span>
                    </div>
                    <div class="summary-row">
                        <span class="text-muted">Shipping</span>
                        <span class="text-success fw-600">FREE</span>
                    </div>
                    <div class="summary-row total-row">
                        <span class="fw-800">Total</span>
                        <span class="fw-800 text-primary fs-5" id="grandTotal">
                            ₹{{ number_format($cart->getTotal() - (session('coupon.discount') ?? 0), 2) }}
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-700 mt-3 fs-6">
                        <i class="bi bi-lock-fill me-2"></i>Place Order
                    </button>
                    <p class="text-center text-muted small mt-2 mb-0">
                        <i class="bi bi-shield-check me-1 text-success"></i>Your information is secure & encrypted
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
// Payment method visual toggle
$('[name="payment_method"]').on('change', function () {
    $('.payment-option').css('opacity', '0.5').css('border-color', '#dee2e6').css('background', '');
    $('label[for="' + $(this).attr('id') + '"]').css('opacity', '1')
        .css('border-color', '#6C3AFF').css('background', 'rgba(108,58,255,0.04)');
});
// Init
$('#pay_cod').trigger('change');
$('[for="pay_online"]').css('opacity', 0.5);
</script>
@endsection
