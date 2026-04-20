@extends('layouts.admin')
@section('title', 'Order #'.$order->order_number)

@section('content')
<div class="page-header">
    <div>
        <h2>Order: <span class="text-primary">{{ $order->order_number }}</span></h2>
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active">{{ $order->order_number }}</li>
        </ol>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<div class="row g-4">
    <!-- LEFT -->
    <div class="col-lg-8">
        <!-- Items -->
        <div class="admin-form-card mb-4">
            <h6 class="fw-700 mb-4 border-bottom pb-3">👟 Order Items</h6>
            @foreach($order->items as $item)
            <div class="d-flex gap-3 align-items-center mb-3 pb-3 border-bottom">
                <img src="{{ $item->product_image ? asset('storage/'.$item->product_image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=80&q=70' }}"
                     style="width:60px;height:60px;object-fit:cover;border-radius:12px;flex-shrink:0;" alt="{{ $item->product_name }}">
                <div class="flex-grow-1">
                    <div class="fw-700">{{ $item->product_name }}</div>
                    <div class="small text-muted">
                        Qty: <strong>{{ $item->quantity }}</strong>
                        @if($item->size) | Size: <strong>{{ $item->size }}</strong> @endif
                        @if($item->color) | Color: <strong>{{ $item->color }}</strong> @endif
                    </div>
                </div>
                <div>
                    <div class="fw-700 text-end">₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                    <div class="small text-muted text-end">₹{{ number_format($item->price, 2) }} each</div>
                </div>
            </div>
            @endforeach
            <!-- Totals -->
            <div class="d-flex justify-content-between"><span>Subtotal</span><span class="fw-600">₹{{ number_format($order->subtotal, 2) }}</span></div>
            @if($order->discount > 0)
            <div class="d-flex justify-content-between text-success"><span>Discount ({{ $order->coupon->code ?? '' }})</span><span class="fw-600">- ₹{{ number_format($order->discount, 2) }}</span></div>
            @endif
            <div class="d-flex justify-content-between fw-800 fs-5 border-top pt-2 mt-2">
                <span>Total</span><span class="text-primary">₹{{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="admin-form-card">
            <h6 class="fw-700 mb-3 border-bottom pb-3">📦 Shipping Details</h6>
            <div class="row g-2">
                <div class="col-sm-6"><div class="small text-muted">Name</div><div class="fw-600">{{ $order->shipping_name }}</div></div>
                <div class="col-sm-6"><div class="small text-muted">Email</div><div class="fw-600">{{ $order->shipping_email }}</div></div>
                <div class="col-sm-6"><div class="small text-muted">Phone</div><div class="fw-600">{{ $order->shipping_phone }}</div></div>
                <div class="col-sm-6"><div class="small text-muted">City</div><div class="fw-600">{{ $order->shipping_city }} {{ $order->shipping_zip }}</div></div>
                <div class="col-12"><div class="small text-muted">Address</div><div class="fw-600">{{ $order->shipping_address }}</div></div>
                @if($order->notes)
                <div class="col-12"><div class="small text-muted">Order Notes</div><div class="fw-600">{{ $order->notes }}</div></div>
                @endif
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="col-lg-4">
        <!-- Status Update -->
        <div class="admin-form-card mb-4">
            <h6 class="fw-700 mb-4 border-bottom pb-3">🔄 Update Status</h6>
            <div class="mb-3">
                <span class="status-badge status-{{ $order->status }} d-block text-center py-2 mb-3" style="font-size:0.9rem;">
                    Current: {{ ucfirst($order->status) }}
                </span>
            </div>
            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <label class="form-label">New Status</label>
                    <select name="status" class="form-select">
                        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Status</button>
            </form>
        </div>

        <!-- Order Info -->
        <div class="admin-form-card">
            <h6 class="fw-700 mb-4 border-bottom pb-3">ℹ️ Order Info</h6>
            <div class="mb-2"><div class="small text-muted">Order #</div><div class="fw-700 text-primary">{{ $order->order_number }}</div></div>
            <div class="mb-2"><div class="small text-muted">Customer</div><div class="fw-600">{{ $order->user->name ?? 'Guest' }}</div></div>
            <div class="mb-2"><div class="small text-muted">Date</div><div class="fw-600">{{ $order->created_at->format('d M Y, h:i A') }}</div></div>
            <div class="mb-2"><div class="small text-muted">Payment</div><div class="fw-600">{{ strtoupper($order->payment_method) }}
                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }} ms-1 rounded-pill">{{ ucfirst($order->payment_status) }}</span>
            </div></div>
            <div class="mb-2"><div class="small text-muted">Total</div><div class="fw-800 text-primary fs-5">₹{{ number_format($order->total, 2) }}</div></div>
        </div>
    </div>
</div>
@endsection
