@extends('layouts.app')
@section('title', 'Order Details')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order {{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-800 mb-0">Order: <span class="text-primary">{{ $order->order_number }}</span></h5>
                        <small class="text-muted">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</small>
                    </div>
                    <div>
                        @if($order->status === 'delivered')
                            <span class="badge bg-success py-2 px-3 fw-600">Delivered</span>
                        @elseif($order->status === 'shipped')
                            <span class="badge bg-info py-2 px-3 fw-600">Shipped</span>
                        @elseif($order->status === 'cancelled')
                            <span class="badge bg-danger py-2 px-3 fw-600">Cancelled</span>
                        @else
                            <span class="badge bg-warning text-dark py-2 px-3 fw-600">Processing</span>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4">
                    <h6 class="fw-700 mb-3">Items in your order</h6>
                    <div class="table-responsive">
                        <table class="table align-middle border-light">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $item->product && $item->product->image ? asset('storage/'.$item->product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100&q=70' }}" 
                                                 alt="{{ $item->product_name }}" 
                                                 style="width:60px; height:60px; object-fit:cover; border-radius:10px;">
                                            <div>
                                                <a href="{{ $item->product ? route('shop.show', $item->product->slug) : '#' }}" class="fw-600 text-decoration-none text-dark d-block">
                                                    {{ $item->product_name }}
                                                </a>
                                                <div class="text-muted small">
                                                    @if($item->size) Size: {{ $item->size }} @endif
                                                    @if($item->color) | Color: {{ $item->color }} @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₹{{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end fw-700">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-800 mb-3"><i class="bi bi-wallet2 text-primary me-2"></i>Order Summary</h6>
                    
                    <div class="d-flex justify-content-between mb-2 small text-muted">
                        <span>Subtotal</span>
                        <span class="fw-600 text-dark">₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    
                    @if($order->discount > 0)
                    <div class="d-flex justify-content-between mb-2 small text-success">
                        <span>Discount @if($order->coupon)({{ $order->coupon->code }})@endif</span>
                        <span class="fw-700">- ₹{{ number_format($order->discount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-between mb-3 small text-muted">
                        <span>Shipping</span>
                        <span class="fw-600 text-success">Free</span>
                    </div>

                    <hr class="text-muted">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-800 text-dark">Grand Total</span>
                        <span class="fw-800 text-primary fs-5">₹{{ number_format($order->total, 2) }}</span>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-700 mb-2 small text-muted text-uppercase">Payment Details</h6>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-600 small">Method:</span>
                            @if($order->payment_method === 'cod')
                                <span class="badge bg-secondary">Cash on Delivery</span>
                            @else
                                <span class="badge bg-primary">Razorpay Online</span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-600 small">Status:</span>
                            @if($order->payment_status === 'paid')
                                <span class="badge bg-success text-white"><i class="bi bi-check-circle me-1"></i>Paid</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pending</span>
                            @endif
                        </div>
                        
                        @if($order->razorpay_payment_id)
                            <div class="mt-2 text-muted small" style="font-size: 0.75rem;">
                                Trans ID: {{ $order->razorpay_payment_id }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Shipping Details -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-800 mb-3"><i class="bi bi-truck text-primary me-2"></i>Shipping Address</h6>
                    <div class="text-muted small lh-lg">
                        <strong class="text-dark">{{ $order->shipping_name }}</strong><br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }} @if($order->shipping_zip) , {{ $order->shipping_zip }} @endif<br>
                        <i class="bi bi-telephone text-primary me-1 mt-2 d-inline-block"></i> {{ $order->shipping_phone }}<br>
                        <i class="bi bi-envelope text-primary me-1"></i> {{ $order->shipping_email }}
                    </div>

                    @if($order->notes)
                        <hr>
                        <h6 class="fw-700 small text-muted text-uppercase mt-3 mb-2">Order Notes</h6>
                        <p class="small text-muted mb-0">{{ $order->notes }}</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
