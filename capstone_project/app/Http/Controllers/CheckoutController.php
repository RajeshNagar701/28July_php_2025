<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the checkout page.
     */
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        $user = auth()->user();
        return view('frontend.checkout', compact('cart', 'user'));
    }

    /**
     * Apply a coupon code (AJAX).
     */
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();
        $cart   = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found.']);
        }

        $total = $cart->getTotal();

        if (!$coupon || !$coupon->isValid($total)) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon.']);
        }

        $discount = $coupon->calculateDiscount($total);
        session(['coupon' => ['id' => $coupon->id, 'code' => $coupon->code, 'discount' => $discount]]);

        return response()->json([
            'success'  => true,
            'message'  => "Coupon applied! You saved ₹" . number_format($discount, 2),
            'discount' => number_format($discount, 2),
            'total'    => number_format($total - $discount, 2),
        ]);
    }

    /**
     * Remove applied coupon (AJAX).
     */
    public function removeCoupon()
    {
        session()->forget('coupon');
        return response()->json(['success' => true]);
    }

    /**
     * Place the order.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_email'   => 'required|email',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string|max:100',
            'shipping_zip'     => 'nullable|string|max:20',
            'payment_method'   => 'required|in:cod,online',
            'notes'            => 'nullable|string|max:500',
        ]);

        $cart = Cart::where('user_id', auth()->id())
            ->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        $subtotal = $cart->getTotal();

        // Apply coupon
        $couponData = session('coupon');
        $discount   = $couponData['discount'] ?? 0;
        $couponId   = $couponData['id'] ?? null;
        $total      = $subtotal - $discount;

        // Create order
        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'SS-' . strtoupper(Str::random(8)),
            'subtotal'         => $subtotal,
            'discount'         => $discount,
            'total'            => $total,
            'status'           => 'pending',
            'payment_method'   => $request->payment_method,
            'payment_status'   => 'pending',
            'shipping_name'    => $request->shipping_name,
            'shipping_email'   => $request->shipping_email,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city'    => $request->shipping_city,
            'shipping_zip'     => $request->shipping_zip,
            'coupon_id'        => $couponId,
            'notes'            => $request->notes,
        ]);

        // Create order items & update product stock
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $item->product_id,
                'product_name'  => $item->product->name,
                'product_image' => $item->product->image,
                'quantity'      => $item->quantity,
                'price'         => $item->product->price,
                'size'          => $item->size,
                'color'         => $item->color,
            ]);

            // Reduce stock
            $item->product->decrement('quantity', $item->quantity);
        }

        // Increment coupon usage
        if ($couponId) {
            Coupon::find($couponId)->increment('used_count');
            session()->forget('coupon');
        }

        // Clear the cart
        $cart->items()->delete();

        if ($request->payment_method === 'online') {
            return redirect()->route('checkout.payment', $order->id);
        }

        return redirect()->route('orders.confirmation', $order->order_number)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Show Payment Page & Generate Razorpay Order.
     */
    public function payment(Order $order)
    {
        // Make sure order belongs to auth user and is pending/unpaid
        if ($order->user_id !== auth()->id() || $order->payment_status === 'paid') {
            return redirect()->route('home')->with('error', 'Invalid order or already paid.');
        }

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        // Amount in paise
        $amount = round($order->total * 100);

        // Generate Razorpay Order ID if not already generated
        if (!$order->razorpay_order_id) {
            $razorpayOrder = $api->order->create([
                'receipt'         => $order->order_number,
                'amount'          => $amount,
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ]);

            $order->razorpay_order_id = $razorpayOrder['id'];
            $order->save();
        }

        return view('frontend.payment', compact('order'));
    }

    /**
     * Handle Razorpay Payment Callback.
     */
    public function paymentCallback(Request $request)
    {
        $input = $request->all();

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $attributes = array(
                'razorpay_order_id'   => $input['razorpay_order_id'],
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'razorpay_signature'  => $input['razorpay_signature']
            );

            $api->utility->verifyPaymentSignature($attributes);
        } catch (SignatureVerificationError $e) {
            \Log::error('Razorpay Sig verification failed', [
                'error' => $e->getMessage(),
                'input' => $input,
                'key_length' => strlen((string)config('services.razorpay.key')),
                'sec_length' => strlen((string)config('services.razorpay.secret'))
            ]);
            return redirect()->route('home')->with('error', 'Payment failed or invalid signature. Please try again.');
        }

        $order = Order::where('razorpay_order_id', $input['razorpay_order_id'])->firstOrFail();

        // Payment verified, update status
        $order->update([
            'payment_status'      => 'paid',
            'razorpay_payment_id' => $input['razorpay_payment_id'],
            'razorpay_signature'  => $input['razorpay_signature'],
        ]);

        return redirect()->route('orders.confirmation', $order->order_number)
            ->with('success', 'Payment successful! Order confirmed.');
    }
}
