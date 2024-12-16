<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Order::with(['user', 'orderItems']);
            
            if ($request->has('search')) {
                $search = $request->get('search');
                $query->where(function($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function($query) use ($search) {
                          $query->where('username', 'like', "%{$search}%");
                      });
                });
            }
            
            $orders = $query->latest()->get();
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            return view('orders.index', ['orders' => collect([])]);
        }
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('orders.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'payment_method' => 'required|string',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                $totalAmount += $product->price * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => $request->user_id,
                'total_amount' => $totalAmount,
                'status' => 'pending'
            ]);

            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_id' => $product->product_id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ]);
            }

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    public function show($order_id)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();
        $order->load(['user', 'orderItems.product']);
        return view('orders.show', compact('order'));
    }

    public function edit($order_id)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();
        $order->load(['user', 'orderItems.product']);
        $users = User::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'users', 'products'));
    }

    public function update(Request $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->firstOrFail();
        $request->validate([
            'status' => 'required|in:pending,completed,shipped,canceled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    public function destroy($order_id)
    {
        try {
            DB::beginTransaction();
            
            // First delete related payments
            DB::table('payments')->where('order_id', $order_id)->delete();
            
            // Then delete order items
            $items = OrderItem::where('order_id', $order_id)->get();
            foreach ($items as $item) {
                $item->delete();
            }
            
            // Finally delete the order
            $order = Order::where('order_id', $order_id)->firstOrFail();
            $deleted = $order->delete();
            
            DB::commit();
            
            if ($deleted) {
                return redirect()->route('orders.index')->with('success', 'Order and related records deleted successfully');
            } else {
                return back()->with('error', 'Failed to delete order');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }

    public function destroyItem(OrderItem $orderItem)
    {
        try {
            DB::beginTransaction();
            
            // Get the order before deleting the item
            $order = $orderItem->order;
            
            // Calculate the amount to subtract
            $subtractAmount = $orderItem->price * $orderItem->quantity;
            
            // Delete the order item
            $orderItem->delete();
            
            // Update the order total
            $order->update([
                'total_amount' => $order->total_amount - $subtractAmount
            ]);
            
            DB::commit();
            return back()->with('success', 'Order item deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error deleting order item: ' . $e->getMessage());
        }
    }
}
