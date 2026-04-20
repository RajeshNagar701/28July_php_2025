@extends('layouts.app')
@section('title', 'My Cart')

@section('content')
<div class="container py-5">
    <h1 class="fw-800 mb-1" style="font-size:1.8rem;">Shopping Cart</h1>
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Cart</li>
        </ol>
    </nav>

    @if($cart->items->isEmpty())
    <!-- EMPTY CART -->
    <div class="text-center py-5">
        <i class="bi bi-bag-x" style="font-size:5rem; color:#ddd;"></i>
        <h4 class="fw-700 mt-3 mb-2">Your cart is empty</h4>
        <p class="text-muted">Looks like you haven't added anything yet.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-primary px-5 mt-2">
            <i class="bi bi-bag me-2"></i>Start Shopping
        </a>
    </div>

    @else
    <div class="row g-4">
        <!-- ====== CART ITEMS ====== -->
        <div class="col-lg-8">
            <div class="admin-table-wrapper mb-3">
                <div class="admin-table-header">
                    <h6 class="mb-0 fw-700">{{ $cart->items->count() }} Item(s)</h6>
                    <button class="btn btn-sm btn-outline-danger rounded-pill" id="clearCartBtn">
                        <i class="bi bi-trash me-1"></i>Clear Cart
                    </button>
                </div>
            </div>

            @foreach($cart->items as $item)
            <div class="cart-item" id="cart-item-{{ $item->id }}">
                <div class="d-flex gap-3 align-items-start flex-wrap flex-md-nowrap">
                    <!-- Image -->
                    <a href="{{ route('shop.show', $item->product->slug) }}">
                        <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=200&q=70' }}"
                             alt="{{ $item->product->name }}" class="cart-item-img"
                             style="width:90px; height:90px; object-fit:cover; border-radius:12px; flex-shrink:0;">
                    </a>

                    <!-- Info -->
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <a href="{{ route('shop.show', $item->product->slug) }}"
                                   class="fw-700 text-dark text-decoration-none d-block">{{ $item->product->name }}</a>
                                <div class="small text-muted mt-1">
                                    @if($item->size)  <span class="me-3"><i class="bi bi-rulers me-1"></i>Size: <strong>{{ $item->size }}</strong></span> @endif
                                    @if($item->color) <span><i class="bi bi-palette me-1"></i>Color: <strong>{{ $item->color }}</strong></span> @endif
                                </div>
                                <div class="small text-primary fw-600 mt-1">₹{{ number_format($item->product->price, 2) }} each</div>
                            </div>
                            <!-- Remove -->
                            <button class="btn btn-sm btn-icon btn-remove-item text-danger" data-item-id="{{ $item->id }}" title="Remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <!-- Qty & Subtotal -->
                        <div class="d-flex align-items-center justify-content-between mt-3 flex-wrap gap-2">
                            <div class="qty-control">
                                <button class="qty-btn" data-action="dec" data-item-id="{{ $item->id }}">−</button>
                                <input type="number" class="qty-input" value="{{ $item->quantity }}"
                                       min="1" data-item-id="{{ $item->id }}">
                                <button class="qty-btn" data-action="inc" data-item-id="{{ $item->id }}">+</button>
                            </div>
                            <div class="fw-800 text-primary" id="subtotal-{{ $item->id }}">
                                ₹{{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Continue Shopping -->
            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary rounded-pill mt-2">
                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
            </a>
        </div>

        <!-- ====== CART SUMMARY ====== -->
        <div class="col-lg-4">
            <div class="cart-summary">
                <h5 class="fw-800 mb-4">Order Summary</h5>

                <div class="summary-row">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-600" id="cartTotal">₹{{ number_format($cart->getTotal(), 2) }}</span>
                </div>
                <div class="summary-row">
                    <span class="text-muted">Shipping</span>
                    <span class="text-success fw-600">{{ $cart->getTotal() >= 999 ? 'FREE' : '₹79' }}</span>
                </div>
                <div class="summary-row total-row">
                    <span class="fw-800">Total</span>
                    <span class="fw-800 text-primary" id="cartGrandTotal">
                        ₹{{ number_format($cart->getTotal() + ($cart->getTotal() >= 999 ? 0 : 79), 2) }}
                    </span>
                </div>

                @auth
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-3 mt-2 fs-6 fw-700">
                        <i class="bi bi-lock-fill me-2"></i>Proceed to Checkout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary w-100 py-3 mt-2 fs-6 fw-700">
                        <i class="bi bi-person me-2"></i>Login to Checkout
                    </a>
                @endauth

                <!-- Trust badges -->
                <div class="text-center mt-3">
                    <div class="small text-muted mb-2"><i class="bi bi-shield-lock me-1"></i>Secure Checkout</div>
                    <div class="d-flex justify-content-center gap-2">
                        <img src="https://img.icons8.com/color/36/000000/visa.png" height="24" alt="Visa">
                        <img src="https://img.icons8.com/color/36/000000/mastercard.png" height="24" alt="Mastercard">
                        <img src="https://img.icons8.com/color/36/000000/upi.png" height="24" alt="UPI">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Clear cart
$('#clearCartBtn').on('click', function () {
    if (!confirm('Clear all cart items?')) return;
    $.ajax({
        url: '{{ route("cart.clear") }}',
        type: 'DELETE',
        success: function () { location.reload(); }
    });
});
</script>
@endsection
