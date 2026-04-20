@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h2>Dashboard</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item active">Overview</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Product
    </a>
</div>

<!-- ====== STAT CARDS ====== -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card primary">
            <div class="stat-icon purple"><i class="bi bi-box-seam"></i></div>
            <div class="stat-value">{{ number_format($totalProducts) }}</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card secondary">
            <div class="stat-icon orange"><i class="bi bi-receipt"></i></div>
            <div class="stat-value">{{ number_format($totalOrders) }}</div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> {{ $pendingOrders }} pending</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card success">
            <div class="stat-icon green"><i class="bi bi-people"></i></div>
            <div class="stat-value">{{ number_format($totalCustomers) }}</div>
            <div class="stat-label">Customers</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card warning">
            <div class="stat-icon yellow"><i class="bi bi-currency-rupee"></i></div>
            <div class="stat-value">₹{{ number_format($totalRevenue, 0) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
    </div>
</div>

<!-- ====== CHARTS ROW ====== -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-700 mb-0">Monthly Revenue ({{ date('Y') }})</h6>
            </div>
            <canvas id="revenueChart" height="110"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="chart-card h-100">
            <h6 class="fw-700 mb-4">Order Status</h6>
            <canvas id="orderStatusChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- ====== TABLES ROW ====== -->
<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="admin-table-wrapper">
            <div class="admin-table-header">
                <h5>Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary fw-600">{{ $order->order_number }}</a></td>
                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                        <td class="fw-600">₹{{ number_format($order->total, 2) }}</td>
                        <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="small text-muted">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-lg-4">
        <div class="admin-table-wrapper">
            <div class="admin-table-header">
                <h5>Top Products</h5>
            </div>
            <div class="p-3">
                @forelse($topProducts as $i => $product)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="fw-800 text-muted" style="width:20px;">{{ $i+1 }}</div>
                    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=60&q=70' }}"
                         class="product-thumb" alt="{{ $product->name }}">
                    <div class="flex-grow-1">
                        <div class="fw-700 small">{{ Str::limit($product->name, 22) }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">{{ $product->order_items_count }} sold</div>
                    </div>
                    <div class="fw-700 text-primary small">₹{{ number_format($product->price, 0) }}</div>
                </div>
                @empty
                <p class="text-muted text-center py-3">No data yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Revenue Chart
const revenueData = @json($monthlyRevenue);
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const labels = revenueData.map(d => months[d.month - 1]);
const data   = revenueData.map(d => d.revenue);

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Revenue (₹)',
            data: data,
            borderColor: '#6C3AFF',
            backgroundColor: 'rgba(108,58,255,0.08)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#6C3AFF',
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f0f2f8' } },
            x: { grid: { display: false } }
        }
    }
});

// Order Status Donut Chart
new Chart(document.getElementById('orderStatusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
        datasets: [{
            data: [
                {{ \App\Models\Order::where('status','pending')->count() }},
                {{ \App\Models\Order::where('status','processing')->count() }},
                {{ \App\Models\Order::where('status','shipped')->count() }},
                {{ \App\Models\Order::where('status','delivered')->count() }},
                {{ \App\Models\Order::where('status','cancelled')->count() }},
            ],
            backgroundColor: ['#f59e0b','#3b82f6','#7c3aed','#10b981','#ef4444'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16 } }
        }
    }
});
</script>
@endsection
