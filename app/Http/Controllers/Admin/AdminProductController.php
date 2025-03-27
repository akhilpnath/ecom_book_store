<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Product::pluck('category')->unique()->filter()->values();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'category' => 'required|string|max:20',
                'details' => 'required|string|max:500',
                'price' => 'required|numeric|min:0',
                'authors' => 'required|string|max:500',
                'language' => 'required|string|max:500',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            if (Product::where('name', $request->name)->exists()) {
                return redirect()->back()->with('error', 'Product name already exists!');
            }

            // Store Image
            $imagePath = $request->file('image')->store('images/product_image', 'public');

            // Create Product
            $product = Product::create([
                'name' => $request->name,
                'category' => $request->category,
                'details' => $request->details,
                'authors' => $request->authors,
                'language' => $request->language,
                'price' => $request->price,
                'image' => $imagePath,
            ]);

            if (!$product) {
                Log::error('Product creation failed', ['request' => $request->all()]);
                return redirect()->back()->with('error', 'Failed to add product. Please try again.');
            }

            return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');

        } catch (\Exception $e) {
            Log::error('Error adding product: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'An error occurred. Check logs for details.');
        }
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:20',
            'details' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'authors' => 'required|string|max:500',
            'language' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('images/product_image', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'details' => $request->details,
            'authors' => $request->authors,
            'language' => $request->language,
            'price' => $request->price,
            'image' => $product->image,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->image);

        Wishlist::where('product_id', $product->id)->delete();
        Cart::where('product_id', $product->id)->delete();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}