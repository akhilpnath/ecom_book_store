<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class UserCartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $grandTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        return view('user.cart', compact('cartItems', 'grandTotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'p_qty' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product already exists in cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->p_qty
            ]);
            return redirect()->back()->with('success', 'Product quantity updated in cart!');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->p_qty,
                'image' => $product->image,
            ]);

            return redirect()->back()->with('success', 'Product added to cart!');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:cart,id',
            'p_qty' => 'required|numeric|min:1',
        ]);

        $cartItem = Cart::findOrFail($request->cart_id);
        $cartItem->update(['quantity' => $request->p_qty]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function delete($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function deleteAll()
    {
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Cart cleared!');
    }
}