<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with analytics.
     */
    public function index()
    {
        $data = [
            'totalProducts'  => Product::count(),
            'totalOrders'    => Order::count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'totalRevenue'   => Order::where('status', '!=', 'cancelled')->sum('total'),
            'pendingOrders'  => Order::where('status', 'pending')->count(),
            'recentOrders'   => Order::with('user')->latest()->take(10)->get(),
            'recentProducts' => Product::with('category')->latest()->take(6)->get(),
            // Monthly revenue for chart (last 6 months)
            'monthlyRevenue' => Order::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
                ->where('status', '!=', 'cancelled')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            'topProducts' => Product::withCount('orderItems')
                ->orderByDesc('order_items_count')
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
