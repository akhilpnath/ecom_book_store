<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|max:20',
            'details' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if product name already exists
        $existingProduct = Product::where('name', $request->name)->first();
        if ($existingProduct) {
            return redirect()->back()->with('error', 'Product name already exists!');
        }

        // Store the image
        $imagePath = $request->file('image')->store('uploaded_img', 'public');

        // Create the product
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'details' => $request->details,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update the image if a new one is provided
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $imagePath = $request->file('image')->store('uploaded_img', 'public');
            $product->image = $imagePath;
        }

        // Update the product
        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'details' => $request->details,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete the product image
        Storage::disk('public')->delete($product->image);

        // Delete related records in wishlist and cart
        Wishlist::where('product_id', $product->id)->delete();
        Cart::where('product_id', $product->id)->delete();

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}