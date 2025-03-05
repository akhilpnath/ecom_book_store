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
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function checkoutForm()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Prevent users from proceeding if the cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty. Add items before proceeding to checkout.');
        }

        $grandTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('user.checkout', compact('cartItems', 'grandTotal'));
    }

    public function checkout(Request $request)
    {
        // Ensure the user has items in the cart before checkout
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty. Add items before checking out.');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'number' => 'required|string|max:12',
            'email' => 'required|email',
            'method' => 'required|string',
            'address' => 'required|string',
        ]);

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

        // Clear the cart after order placement
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.orders')->with('success', 'Your order has been placed successfully!');
    }
}
