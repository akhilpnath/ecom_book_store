<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function home()
    {

        $products = Cache::remember('categories_list', now()->addHours(3), function () {
            return Product::latest()->limit(8)->get();
        });

        // Use a subquery to get the latest product for each category in a single query
        $categories = Cache::remember('categories_list', now()->addHours(3), function () {
            return DB::table('products as p1')
                ->join(DB::raw('(
                    SELECT category, MAX(created_at) as max_date
                    FROM products
                    WHERE category IS NOT NULL
                    GROUP BY category
                ) as p2'), function ($join) {
                    $join->on('p1.category', '=', 'p2.category')
                        ->on('p1.created_at', '=', 'p2.max_date');
                })
                ->select(
                    'p1.category as name',
                    'p1.image',
                    DB::raw("CONCAT('Explore books in ', p1.category, ' category.') as description")
                )
                ->get()
                ->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'image' => $item->image,
                        'desc' => $item->description
                    ];
                });
        });


        return view('user.home', compact('products', 'categories'));
    }
    public function destroyUserAccount(User $user)
    {
        $user->delete();
        Auth::logout();
        return redirect()->route('login')->with('success', "{$user->name} your account deleted successfully!");
    }

}