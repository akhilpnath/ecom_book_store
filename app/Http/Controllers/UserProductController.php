<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserProductController extends Controller
{
    public function shop()
    {
        $products = Product::all();
        return view('user.shop', compact('products'));
    }

    public function category($category)
    {
        $products = Product::where('category', $category)->get();
        return view('user.category', compact('products', 'category'));
    }

    public function view($id)
    {
        $product = Product::findOrFail($id);
        return view('user.product.view', compact('product'));
    }
}