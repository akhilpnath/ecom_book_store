<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Message;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Existing data
        $totalPendings = Order::where('payment_status', 'pending')->sum('total_price');
        $totalCompleted = Order::where('payment_status', 'completed')->sum('total_price');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $inactiveUsers = User::where('status', '0')->count();
        $totalAdmins = User::where('user_type', 'admin')->count();
        $totalAccounts = User::count();
        $totalMessages = Message::count();

        $ordersData = $this->getOrdersData();

        $usersData = $this->getUsersData();

        return view('admin.dashboard', compact(
            'totalPendings',
            'totalCompleted',
            'totalOrders',
            'totalProducts',
            'inactiveUsers',
            'totalAdmins',
            'totalAccounts',
            'totalMessages',
            'ordersData',
            'usersData'
        ));
    }

    private function getOrdersData()
    {
        $orders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $ordersData = array_fill(0, 12, 0); // Initialize array with 12 months

        foreach ($orders as $order) {
            $ordersData[$order->month - 1] = $order->count; // Subtract 1 to match array index
        }

        return $ordersData;
    }

    private function getUsersData()
    {
        $users = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $usersData = array_fill(0, 12, 0); // Initialize array with 12 months

        foreach ($users as $user) {
            $usersData[$user->month - 1] = $user->count; // Subtract 1 to match array index
        }

        return $usersData;
    }
}