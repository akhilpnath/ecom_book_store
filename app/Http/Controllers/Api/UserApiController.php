<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function login()
    {
        $userEmail = request('email');
        $userPassword = request('password');

        if (!$userEmail || !$userPassword) {
            return response()->json([
                "message" => 'Email and password are required',
                'status' => false
            ], 422);
        }

        $user = User::where('email', $userEmail)->first();

        if (!$user || !Hash::check($userPassword, $user->password)) {
            return response()->json([
                "message" => 'Invalid email or password',
                'status' => false
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            "message" => 'User logged in successfully',
            'status' => true
        ]);
    }

    public function logout()
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        $user->tokens()->delete();

        return response()->json([
            "message" => 'User logged out successfully',
            'status' => true
        ]);
    }

    public function getUserDetails()
    {
        $userId = auth()->user()->id;

        $user = User::with([
            'carts' => function ($query) {
                $query->select('id', 'user_id', 'product_id', 'name', 'price', 'quantity', 'image');
            },
            'orders' => function ($query) {
                $query->select('user_id', 'name', 'number', 'email', 'method', 'address', 'total_products', 'total_price', 'placed_on', 'payment_status', );
            },
            'wishlists' => function ($query) {
                $query->select('id', 'user_id', 'product_id', 'name', 'price', 'image');
            },
            'cartItems' => function ($query) {
                $query->select('id', 'user_id', 'product_id', 'name', 'price', 'quantity', 'image');
            },
            'Address' => function ($query) {
                $query->select('id', 'user_id', 'address_line_1', 'address_line_2', 'city', 'state', 'country', 'pincode', 'phone_number');
            }
        ])->select('id', 'name', 'email', 'status', 'user_type', 'image')->find($userId);

        return response()->json([
            "user" => $user,
            "userDetails" => [
                'userCarts' => $user->carts,
                'userOrders' => $user->orders,
                'userWishlists' => $user->wishlists,
                'userCartItems' => $user->cartItems,
                'userAddress' => $user->Address,
                'userStatus' => $user->active_status
            ],
            'message' => 'Successfully fetched user details',
            'status' => 200
        ]);
    }


}
