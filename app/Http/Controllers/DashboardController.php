<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category');
        
        $query = Product::latest();
        if ($selectedCategory) {
            $query->where('category_id', $selectedCategory);
        }
        
        $data = [
            'products' => $query->get(),
            'categories' => Category::all(),
            'selectedCategory' => $selectedCategory,
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'totalCustomers' => User::count()
        ];
        
        return view('pages.dashboard', $data);
    }
}
