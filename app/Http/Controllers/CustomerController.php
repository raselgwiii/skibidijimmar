<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $users = User::where('role', 'customer')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customers.index', compact('users', 'search'));
    }

    public function show($id)
    {
        $user = User::where('role', 'customer')
                    ->where('user_id', $id)
                    ->with('orders')  // Eager load orders
                    ->firstOrFail();
        
        $orders = $user->orders()->latest()->get();
        
        return view('customers.show', compact('user', 'orders'));
    }

    public function edit($id)
    {
        $user = User::where('role', 'customer')
                    ->where('user_id', $id)
                    ->firstOrFail();
        return view('customers.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'customer')
                    ->where('user_id', $id)
                    ->firstOrFail();

        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $user->update([
            'status' => $request->status
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer status updated successfully.');
    }
}
