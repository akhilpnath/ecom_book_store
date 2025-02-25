<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class UserController extends Controller
{
    public function home()
    {
        $products = Product::latest()->limit(6)->get();
        return view('user.home', compact('products'));
    }

    
}