@extends('layouts.admin')
@section('title', 'Coupons')

@section('content')
<div class="page-header">
    <div>
        <h2>Coupons</h2>
        <ol class="breadcrumb small mb-0"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Coupons</li></ol>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Coupon</a>
</div>

<div class="admin-table-wrapper">
    <div class="admin-table-header"><h5>All Coupons ({{ $coupons->total() }})</h5></div>
    <table class="table">
        <thead>
            <tr><th>Code</th><th>Discount</th><th>Type</th><th>Min Order</th><th>Used</th><th>Valid Until</th><th>Status</th><th>Action</th></tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
            <tr>
                <td><code class="fw-700 text-primary fs-6">{{ $coupon->code }}</code></td>
                <td class="fw-700">{{ $coupon->type === 'percent' ? $coupon->discount.'%' : '₹'.number_format($coupon->discount,2) }}</td>
                <td><span class="badge {{ $coupon->type === 'percent' ? 'bg-info' : 'bg-warning text-dark' }} rounded-pill">{{ ucfirst($coupon->type) }}</span></td>
                <td class="small">₹{{ number_format($coupon->min_order, 2) }}</td>
                <td><span class="badge bg-secondary rounded-pill">{{ $coupon->used_count }}{{ $coupon->max_uses ? '/'.$coupon->max_uses : '' }}</span></td>
                <td class="small text-muted">{{ $coupon->valid_until ? $coupon->valid_until->format('d M Y') : 'No Expiry' }}</td>
                <td>
                    <span class="status-badge {{ $coupon->status ? 'status-delivered' : 'status-cancelled' }}">
                        {{ $coupon->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="d-flex gap-2">
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger rounded-pill btn-delete"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No coupons yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3 d-flex justify-content-center">{{ $coupons->links() }}</div>
</div>
@endsection
