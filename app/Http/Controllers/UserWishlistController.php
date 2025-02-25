<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class UserWishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())->get();
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $grandTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        return view('user.wishlist', compact('wishlistItems','grandTotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product already exists in wishlist
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlistItem) {
            return redirect()->back()->with('error', 'Product already in wishlist!');
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
        ]);

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function delete($id)
    {
        $wishlistItem = Wishlist::findOrFail($id);
        $wishlistItem->delete();
        return redirect()->back()->with('success', 'Product removed from wishlist!');
    }

    public function deleteAll()
    {
        Wishlist::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Wishlist cleared!');
    }
}