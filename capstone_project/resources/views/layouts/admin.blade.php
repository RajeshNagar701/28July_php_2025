<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | ShoeStore Admin</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Admin CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                <i class="bi bi-bag-heart-fill me-2"></i>
                <span>ShoeStore</span>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Request::is('admin') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>

            <div class="nav-section-title">Catalog</div>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ Request::is('admin/categories*') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap"></i><span>Categories</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ Request::is('admin/products*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i><span>Products</span>
            </a>

            <div class="nav-section-title">Sales</div>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ Request::is('admin/orders*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i><span>Orders</span>
                @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-danger ms-auto">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.customers.index') }}" class="sidebar-link {{ Request::is('admin/customers*') ? 'active' : '' }}">
                <i class="bi bi-people"></i><span>Customers</span>
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="sidebar-link {{ Request::is('admin/coupons*') ? 'active' : '' }}">
                <i class="bi bi-ticket-perforated"></i><span>Coupons</span>
            </a>

            <div class="nav-section-title">Account</div>
            <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                <i class="bi bi-shop"></i><span>View Store</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="sidebar-link w-100 text-start border-0 bg-transparent">
                    <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Top Bar -->
        <header class="admin-topbar">
            <button class="btn btn-icon" id="sidebarToggle">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-muted small">Welcome, <strong>{{ auth()->user()->name }}</strong></span>
                <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="admin-content p-4">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js for analytics -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Sidebar toggle
$('#sidebarToggle').on('click', function () {
    $('#adminSidebar').toggleClass('collapsed');
    $('.admin-main').toggleClass('expanded');
});

// Confirm delete
$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    if (confirm('Are you sure you want to delete this? This action cannot be undone.')) {
        $(this).closest('form').submit();
    }
});
</script>

@yield('scripts')
</body>
</html>
