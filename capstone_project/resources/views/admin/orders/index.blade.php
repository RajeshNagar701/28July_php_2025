@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="page-header">
    <div>
        <h2>Orders</h2>
        <ol class="breadcrumb small mb-0"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Orders</li></ol>
    </div>
</div>

<!-- Filter Bar -->
<div class="admin-form-card mb-4">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 align-items-end">
        <div class="col-md-5">
            <label class="form-label">Search Order #</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="SS-XXXXXXXX">
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h5>All Orders ({{ $orders->total() }})</h5>
    </div>
    <table class="table">
        <thead>
            <tr><th>Order #</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Action</th></tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary fw-700">{{ $order->order_number }}</a></td>
                <td>
                    <div class="fw-600">{{ $order->shipping_name }}</div>
                    <div class="small text-muted">{{ $order->user->email ?? '' }}</div>
                </td>
                <td><span class="badge bg-secondary rounded-pill">{{ $order->items_count ?? '—' }} items</span></td>
                <td class="fw-700">₹{{ number_format($order->total, 2) }}</td>
                <td>
                    <div class="small">{{ strtoupper($order->payment_method) }}</div>
                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill" style="font-size:0.7rem;">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </td>
                <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="bi bi-eye me-1"></i>View
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3 d-flex justify-content-center">{{ $orders->links() }}</div>
</div>
@endsection
