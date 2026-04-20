<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user's wishlist.
     */
    public function index()
    {
        $wishlists = Wishlist::with('product.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('frontend.wishlist', compact('wishlists'));
    }

    /**
     * Toggle product in wishlist (AJAX).
     */
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            $status  = false;
            $message = 'Removed from wishlist.';
        } else {
            Wishlist::create([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
            ]);
            $status  = true;
            $message = 'Added to wishlist!';
        }

        $count = Wishlist::where('user_id', auth()->id())->count();

        return response()->json([
            'success' => true,
            'status'  => $status,  // true = in wishlist, false = removed
            'message' => $message,
            'count'   => $count,
        ]);
    }

    /**
     * Remove from wishlist.
     */
    public function remove(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) abort(403);
        $wishlist->delete();
        return back()->with('success', 'Removed from wishlist.');
    }
}
