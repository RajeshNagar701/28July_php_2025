@extends('layouts.admin')
@section('title', 'Customer Detail')

@section('content')
<div class="page-header">
    <div>
        <h2>Customer Detail</h2>
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
            <li class="breadcrumb-item active">{{ $customer->name }}</li>
        </ol>
    </div>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="admin-form-card text-center mb-4">
            <div style="width:100px; height:100px; background: linear-gradient(135deg, #6C3AFF, #FF6B35); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-size:2.5rem; font-weight:800; margin:0 auto 20px;">
                {{ strtoupper(substr($customer->name, 0, 1)) }}
            </div>
            <h5 class="fw-800">{{ $customer->name }}</h5>
            <p class="text-muted small mb-3">Joined {{ $customer->created_at->format('d M Y') }}</p>

            <div class="text-start mt-4 border-top pt-4">
                <div class="mb-3">
                    <div class="small text-muted"><i class="bi bi-envelope me-2"></i>Email Address</div>
                    <div class="fw-600">{{ $customer->email }}</div>
                </div>
                <div class="mb-3">
                    <div class="small text-muted"><i class="bi bi-telephone me-2"></i>Phone Number</div>
                    <div class="fw-600">{{ $customer->phone ?? 'Not provided' }}</div>
                </div>
                <div class="mb-3">
                    <div class="small text-muted"><i class="bi bi-geo-alt me-2"></i>Default Address</div>
                    <div class="fw-600">{{ $customer->address ?? 'Not provided' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6">
                <div class="stat-card primary p-3">
                    <div class="small text-muted mb-1">Total Orders</div>
                    <h3 class="fw-800 mb-0">{{ $customer->orders->count() }}</h3>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="stat-card success p-3">
                    <div class="small text-muted mb-1">Total Spent</div>
                    <h3 class="fw-800 mb-0">₹{{ number_format($customer->orders->sum('total'), 2) }}</h3>
                </div>
            </div>
        </div>

        <!-- Orders list -->
        <div class="admin-table-wrapper">
            <div class="admin-table-header">
                <h5>Order History</h5>
            </div>
            <table class="table mb-0">
                <thead>
                    <tr><th>Order #</th><th>Date</th><th>Status</th><th>Total</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @forelse($customer->orders()->latest()->get() as $order)
                    <tr>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary fw-600">{{ $order->order_number }}</a></td>
                        <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                        <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="fw-700">₹{{ number_format($order->total, 2) }}</td>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">View</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No orders placed yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
