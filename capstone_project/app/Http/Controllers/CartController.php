<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get or create a cart for the current user/session.
     */
    private function getCart(): Cart
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(['user_id' => auth()->id()]);
        }
        // Guest cart via session
        $sessionId = session()->getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    /**
     * Display the cart page.
     */
    public function index()
    {
        $cart = $this->getCart();
        $cart->load('items.product');
        return view('frontend.cart', compact('cart'));
    }

    /**
     * Add product to cart (AJAX).
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'size'       => 'nullable|string',
            'color'      => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Stock check
        if ($product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.',
            ], 422);
        }

        $cart = $this->getCart();

        // Check if same product+size+color already in cart
        $existing = $cart->items()
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'size'       => $request->size,
                'color'      => $request->color,
            ]);
        }

        $cart->load('items.product');
        $cartCount = $cart->getTotalItems();
        $cartTotal = number_format($cart->getTotal(), 2);

        return response()->json([
            'success'    => true,
            'message'    => 'Product added to cart!',
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal,
        ]);
    }

    /**
     * Update item quantity (AJAX).
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($cartItem->product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock.',
            ], 422);
        }

        $cartItem->update(['quantity' => $request->quantity]);
        $cart = $this->getCart();
        $cart->load('items.product');

        return response()->json([
            'success'    => true,
            'subtotal'   => number_format($cartItem->subtotal, 2),
            'cart_total' => number_format($cart->getTotal(), 2),
            'cart_count' => $cart->getTotalItems(),
        ]);
    }

    /**
     * Remove an item from cart (AJAX).
     */
    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        $cart = $this->getCart();
        $cart->load('items.product');

        return response()->json([
            'success'    => true,
            'message'    => 'Item removed from cart.',
            'cart_count' => $cart->getTotalItems(),
            'cart_total' => number_format($cart->getTotal(), 2),
        ]);
    }

    /**
     * Clear all items from cart (AJAX).
     */
    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();

        return response()->json([
            'success'    => true,
            'message'    => 'Cart cleared.',
            'cart_count' => 0,
            'cart_total' => '0.00',
        ]);
    }

    /**
     * Get cart count for navbar badge (AJAX).
     */
    public function count()
    {
        $cart  = $this->getCart();
        $count = $cart->items()->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
