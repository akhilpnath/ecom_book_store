<?php

namespace App\Http\Controllers;

use App\Events\NewOrderConfirmaationEvent;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $addresses = Address::where('user_id', Auth::id())->latest()->get();

        // If user has no saved addresses, redirect to create address
        if ($addresses->isEmpty()) {
            return redirect()->route('user.address.create')->with('info', 'Please add a shipping address before proceeding to checkout.');
        }

        return view('user.checkout', compact('cartItems', 'grandTotal', 'addresses'));
    }

    public function checkout(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty. Add items before checking out.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'number' => 'required|string|max:12',
            'email' => 'required|email',
            'method' => 'required|string',
        ]);

        // Handle address validation based on user choice
        if ($request->has('use_manual_address') && $request->use_manual_address) {
            $request->validate([
                'address' => 'required|string|min:5',
            ]);
            $shippingAddress = $request->address;
        } else {
            $request->validate([
                'address_id' => 'required|exists:address,id',
            ]);

            // Get the address from database
            $address = Address::where('id', $request->address_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Format the address as a string
            $shippingAddress = "{$address->address_line_1}, " .
                ($address->address_line_2 ? "{$address->address_line_2}, " : "") .
                "{$address->city}, {$address->state}, {$address->country} - {$address->pincode}";
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        try {
            // Start the transaction
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'number' => $request->number,
                'email' => $request->email,
                'method' => $request->method,
                'address' => $shippingAddress,
                'total_products' => $cartItems->pluck('name')->implode(', '),
                'total_price' => $totalPrice,
                'placed_on' => now(),
                'payment_status' => 'pending',
            ]);

            // Dispatch the event for new order confirmation
            event(new NewOrderConfirmaationEvent($order));

            // Clear the cart after order placement
            Cart::where('user_id', Auth::id())->delete();

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If any exception occurs, roll back the transaction
            DB::rollBack();

            // log the error or rethrow it
            Log::error($e->getMessage());
            // throw $e;
        }
        
        return redirect()->route('user.orders')->with('success', 'Your order has been placed successfully!');
    }
}