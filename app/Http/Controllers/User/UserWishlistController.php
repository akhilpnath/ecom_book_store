<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

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
        $grandTotal = round($wishlistItems->sum(function ($item) {
            return $item->price;
        }), 2);

        return view('user.wishlist', compact('wishlistItems', 'grandTotal'));

    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlistItem) {
            return response()->json(['error' => 'Product already in wishlist!'], 409);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
        ]);

        return response()->json(['success' => 'Product added to wishlist!']);
    }


    public function delete($id)
    {
        $wishlistItem = Wishlist::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$wishlistItem) {
            return response()->json(['error' => 'Product not found in your wishlist!']);
        }

        $wishlistItem->delete();

        return redirect()->back()->with('success', 'Product removed from wishlist!');
    }

    public function deleteAll()
    {
        Wishlist::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Wishlist cleared!');
    }
}