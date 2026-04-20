@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <h1 class="fw-800 mb-1" style="font-size:1.8rem;">My Orders</h1>
    <p class="text-muted mb-4">Track and manage your orders</p>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-box" style="font-size:5rem; color:#ddd;"></i>
            <h5 class="fw-700 mt-3">No orders yet</h5>
            <a href="{{ route('shop.index') }}" class="btn btn-primary mt-2">Start Shopping</a>
        </div>
    @else
        <div class="admin-table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><strong class="text-primary">{{ $order->order_number }}</strong></td>
                        <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                        <td><span class="badge bg-secondary rounded-pill">{{ $order->items->count() }} items</span></td>
                        <td><strong>₹{{ number_format($order->total, 2) }}</strong></td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-eye me-1"></i>View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
