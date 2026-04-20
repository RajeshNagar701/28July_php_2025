<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->withCount('orders')->latest()->paginate(15)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load(['orders.items']);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'role'  => 'required|in:customer,admin',
        ]);

        $customer->update($request->only(['name', 'email', 'phone', 'role']));

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer profile updated successfully!');
    }

    public function destroy(User $customer)
    {
        if ($customer->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Cannot delete the last administrator.');
        }

        // Check for orders before delete to prevent data loss
        if ($customer->orders()->count() > 0) {
            return back()->with('error', 'Cannot delete customer with active order history.');
        }

        $customer->delete();
        return back()->with('success', 'User removed successfully.');
    }
}
