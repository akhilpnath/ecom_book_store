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
        // Load necessary user counts in a single query
        $userCounts = User::selectRaw("
        COUNT(*) as totalAccounts, 
        SUM(CASE WHEN status = '0' THEN 1 ELSE 0 END) as inactiveUsers, 
        SUM(CASE WHEN user_type = 'admin' THEN 1 ELSE 0 END) as totalAdmins
        ")->first();

        // Load order statistics in a single query
        $orderStats = Order::selectRaw("
        SUM(CASE WHEN payment_status = 'pending' THEN total_price ELSE 0 END) as totalPendings, 
        SUM(CASE WHEN payment_status = 'completed' THEN total_price ELSE 0 END) as totalCompleted,
        COUNT(*) as totalOrders,
        COUNT(CASE WHEN payment_status = 'pending' THEN 1 END) as totalPendingOrders,
        COUNT(CASE WHEN payment_status = 'completed' THEN 1 END) as totalCompletedOrders
        ")->first();


        $totalProducts = Product::count();
        $totalMessages = Message::count();
        $ordersData = $this->getOrdersData();
        $usersData = $this->getUsersData();

        // Extract values from the objects into individual variables
        $totalPendings = $orderStats->totalPendings ?? 0;
        $totalCompleted = $orderStats->totalCompleted ?? 0;
        $totalOrders = $orderStats->totalOrders ?? 0;
        $inactiveUsers = $userCounts->inactiveUsers ?? 0;
        $totalAdmins = $userCounts->totalAdmins ?? 0;
        $totalAccounts = $userCounts->totalAccounts ?? 0;

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
            ->pluck('count', 'month')
            ->toArray();

        return array_replace(array_fill(0, 12, 0), $orders); // Ensure all months are filled
    }

    private function getUsersData()
    {
        $users = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return array_replace(array_fill(0, 12, 0), $users); // Ensure all months are filled
    }
}
