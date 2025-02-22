<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Message;

class AdminController extends Controller
{
    public function index()
    {
        $totalPendings = Order::where('payment_status', 'pending')->sum('total_price');
        $totalCompleted = Order::where('payment_status', 'completed')->sum('total_price');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('user_type', 'user')->count();
        $totalAdmins = User::where('user_type', 'admin')->count();
        $totalAccounts = User::count();
        $totalMessages = Message::count();
        return view('admin.dashboard', compact(
            'totalPendings',
            'totalCompleted',
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'totalAdmins',
            'totalAccounts',
            'totalMessages'
        ));
    }
}