<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|unique:coupons|max:50',
            'discount'    => 'required|numeric|min:0',
            'type'        => 'required|in:fixed,percent',
            'min_order'   => 'nullable|numeric|min:0',
            'max_uses'    => 'nullable|integer|min:1',
            'valid_from'  => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        Coupon::create([
            'code'        => strtoupper($request->code),
            'discount'    => $request->discount,
            'type'        => $request->type,
            'min_order'   => $request->min_order ?? 0,
            'max_uses'    => $request->max_uses,
            'valid_from'  => $request->valid_from,
            'valid_until' => $request->valid_until,
            'status'      => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code'        => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount'    => 'required|numeric|min:0',
            'type'        => 'required|in:fixed,percent',
            'min_order'   => 'nullable|numeric|min:0',
            'max_uses'    => 'nullable|integer|min:1',
            'valid_from'  => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
        ]);

        $coupon->update([
            'code'        => strtoupper($request->code),
            'discount'    => $request->discount,
            'type'        => $request->type,
            'min_order'   => $request->min_order ?? 0,
            'max_uses'    => $request->max_uses,
            'valid_from'  => $request->valid_from,
            'valid_until' => $request->valid_until,
            'status'      => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Coupon deleted!');
    }
}
