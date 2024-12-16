<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $search = $request->get('search');
            $products = Product::where('name', 'like', "%{$search}%")->latest()->get();
        } else {
            $products = Product::latest()->get();
        }
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,category_id',
            'image_url' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
            $path = $file->move(public_path('images/products'), $filename);
            $validated['image_url'] = 'images/products/' . $filename;
        }

        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,category_id',
            'image_url' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image_url')) {
            // Delete old image if it exists
            if ($product->image_url && file_exists(public_path($product->getRawOriginal('image_url')))) {
                unlink(public_path($product->getRawOriginal('image_url')));
            }
            
            // Store new image
            $file = $request->file('image_url');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
            $path = $file->move(public_path('images/products'), $filename);
            $validated['image_url'] = 'images/products/' . $filename;
        }

        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($product_id)
    {
        try {
            DB::beginTransaction();
            
            $product = Product::findOrFail($product_id);
            
            // Delete all related records first
            DB::table('cart')->where('product_id', $product_id)->delete();
            DB::table('inventory_adjustments')->where('product_id', $product_id)->delete();
            DB::table('order_items')->where('product_id', $product_id)->delete();
            
            // Delete the product image if it exists
            if ($product->image_url && $product->getRawOriginal('image_url') !== 'images/no-image.png' 
                && file_exists(public_path($product->getRawOriginal('image_url')))) {
                unlink(public_path($product->getRawOriginal('image_url')));
            }

            // Delete the product
            $deleted = $product->delete();
            
            if (!$deleted) {
                throw new \Exception('Failed to delete product');
            }
            
            DB::commit();
            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product deletion error: ' . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'Unable to delete product. Error: ' . $e->getMessage());
        }
    }
}