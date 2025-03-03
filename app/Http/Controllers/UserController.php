<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserController extends Controller
{
    public function home()
    {
        $products = Product::latest()->limit(8)->get();

        // Get unique categories that have at least one product
        $categories = Product::select('category')
            ->groupBy('category')
            ->whereNotNull('category')
            ->get()
            ->map(function ($category) {
                // Fetch the latest product image for each category
                $latestProduct = Product::where('category', $category->category)->latest()->first();
                return [
                    'name' => $category->category,
                    'image' => $latestProduct ? $latestProduct->image : 'default.jpg',
                    'desc' => 'Explore books in ' . $category->category . ' category.',
                ];
            });

        return view('user.home', compact('products', 'categories'));
    }


}