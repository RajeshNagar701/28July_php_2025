@extends('layouts.admin')
@section('title', 'Customers')

@section('content')
<div class="page-header">
    <div>
        <h2>Customers</h2>
        <ol class="breadcrumb small mb-0"><li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li><li class="breadcrumb-item active">Customers</li></ol>
    </div>
</div>

<div class="admin-form-card mb-4">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-8">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Name or email...">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Search</button>
        </div>
    </form>
</div>

<div class="admin-table-wrapper">
    <div class="admin-table-header">
        <h5>All Customers ({{ $customers->total() }})</h5>
    </div>
    <table class="table">
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th>Joined</th><th>Action</th></tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            <tr>
                <td class="text-muted small">{{ $customer->id }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#6C3AFF,#FF6B35);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:0.8rem;flex-shrink:0;">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <div class="fw-600">{{ $customer->name }}</div>
                    </div>
                </td>
                <td class="small text-muted">{{ $customer->email }}</td>
                <td class="small">{{ $customer->phone ?? '—' }}</td>
                <td><span class="badge bg-primary rounded-pill">{{ $customer->orders_count }}</span></td>
                <td class="small text-muted">{{ $customer->created_at->format('d M Y') }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-info rounded-pill">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.customers.destroy', $customer->id) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger rounded-pill btn-delete"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No customers found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3 d-flex justify-content-center">{{ $customers->links() }}</div>
</div>
@endsection
