<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show customer's order history.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('frontend.orders', compact('orders'));
    }

    /**
     * Show order details.
     */
    public function show(Order $order)
    {
        // Ensure customer only sees their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('items.product', 'coupon');
        return view('frontend.order-detail', compact('order'));
    }

    /**
     * Order confirmation page after successful checkout.
     */
    public function confirmation(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with('items.product')
            ->firstOrFail();

        return view('frontend.order-confirmation', compact('order'));
    }
}
