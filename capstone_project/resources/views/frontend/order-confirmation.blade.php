@extends('layouts.app')
@section('title', 'Order Confirmed!')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Card -->
            <div class="text-center p-5">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4"
                     style="width:100px; height:100px; background: linear-gradient(135deg, #10b981, #34d399); animation: pulse 2s infinite;">
                    <i class="bi bi-check-lg text-white" style="font-size:2.5rem;"></i>
                </div>
                <h2 class="fw-800 mb-2">Order Placed Successfully! 🎉</h2>
                <p class="text-muted fs-5 mb-1">Thank you for shopping with ShoeStore!</p>
                <p class="text-muted mb-4">Your order <strong class="text-primary">{{ $order->order_number }}</strong> has been received.</p>

                <!-- Status Timeline -->
                <div class="d-flex justify-content-center gap-0 mb-5 flex-wrap">
                    @foreach(['Order Placed', 'Processing', 'Shipped', 'Delivered'] as $i => $step)
                    <div class="text-center" style="min-width: 100px;">
                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center fw-700 text-white"
                             style="width:36px; height:36px; background: {{ $i === 0 ? '#6C3AFF' : '#ddd' }};">
                            {{ $i + 1 }}
                        </div>
                        <div class="small mt-1 {{ $i === 0 ? 'text-primary fw-700' : 'text-muted' }}">{{ $step }}</div>
                    </div>
                    @if(!$loop->last)
                    <div style="width:60px; height:2px; background:#ddd; margin-top:18px;"></div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Order Details -->
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <h5 class="fw-800 mb-4 border-bottom pb-3">Order Details</h5>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="small text-muted">Order Number</div>
                        <div class="fw-700 text-primary">{{ $order->order_number }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted">Order Date</div>
                        <div class="fw-700">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted">Payment Method</div>
                        <div class="fw-700">{{ strtoupper($order->payment_method) }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="small text-muted">Total Amount</div>
                        <div class="fw-800 text-primary fs-5">₹{{ number_format($order->total, 2) }}</div>
                    </div>
                </div>

                <!-- Items -->
                <h6 class="fw-700 mb-3">Items Ordered</h6>
                @foreach($order->items as $item)
                <div class="d-flex gap-3 align-items-center mb-3 pb-3 border-bottom">
                    <img src="{{ $item->product_image ? asset('storage/'.$item->product_image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=80&q=70' }}"
                         style="width:60px; height:60px; object-fit:cover; border-radius:12px; flex-shrink:0;"
                         alt="{{ $item->product_name }}">
                    <div class="flex-grow-1">
                        <div class="fw-700">{{ $item->product_name }}</div>
                        <div class="small text-muted">
                            Qty: {{ $item->quantity }}
                            @if($item->size) | Size: {{ $item->size }} @endif
                            @if($item->color) | Color: {{ $item->color }} @endif
                        </div>
                    </div>
                    <div class="fw-700">₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                </div>
                @endforeach

                <!-- Total -->
                <div class="d-flex justify-content-between pt-2">
                    <span class="fw-800">Total Paid</span>
                    <span class="fw-800 text-primary fs-5">₹{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <h5 class="fw-800 mb-3"><i class="bi bi-geo-alt text-primary me-2"></i>Shipping Address</h5>
                <p class="mb-1 fw-600">{{ $order->shipping_name }}</p>
                <p class="mb-1 text-muted">{{ $order->shipping_address }}, {{ $order->shipping_city }} {{ $order->shipping_zip }}</p>
                <p class="mb-0 text-muted">{{ $order->shipping_phone }} | {{ $order->shipping_email }}</p>
            </div>

            <!-- CTA Buttons -->
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('orders.index') }}" class="btn btn-primary px-4">
                    <i class="bi bi-box me-2"></i>My Orders
                </a>
                <a href="{{ route('shop.index') }}" class="btn btn-outline-primary px-4">
                    <i class="bi bi-bag me-2"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
