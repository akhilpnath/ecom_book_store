<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('user.orders', compact('orders'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'number' => 'required|string|max:12',
            'email' => 'required|email',
            'method' => 'required|string',
            'address' => 'required|string',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'number' => $request->number,
            'email' => $request->email,
            'method' => $request->method,
            'address' => $request->address,
            'total_products' => $cartItems->pluck('name')->implode(', '),
            'total_price' => $totalPrice,
            'placed_on' => now(),
            'payment_status' => 'pending',
        ]);

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.orders')->with('success', 'Order placed successfully!');
    }
}