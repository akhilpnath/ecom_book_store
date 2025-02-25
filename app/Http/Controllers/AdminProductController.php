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
            'authors' => 'required|string|max:500',
            'language' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $existingProduct = Product::where('name', $request->name)->first();
        if ($existingProduct) {
            return redirect()->back()->with('error', 'Product name already exists!');
        }

        $imagePath = $request->file('image')->storeAs('images/product_image', time() . '.' . $request->file('image')->getClientOriginalExtension(), 'public');

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'details' => $request->details,
            'authors' => $request->authors,
            'language' => $request->language,
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
            'authors' => 'required|string|max:500',
            'language' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->storeAs(
                'images/product_image',
                time() . '.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );
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
