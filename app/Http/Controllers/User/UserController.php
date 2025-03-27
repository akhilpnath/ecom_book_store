<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function home()
    {
        $products = Cache::remember('products_list', now()->addHours(3), function () {
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

    public function exportUserDetails()
    {
        $data = User::with([
            'orders:id,user_id,name,number,email,method,address,total_products,total_price,placed_on,payment_status',
            'Address:id,user_id,address_line_1,address_line_2,city,state,country,pincode,phone_number'
        ])
            ->select('id', 'name', 'email', 'image', 'status')
            ->where('id', Auth::id())
            ->get()
            ->flatMap(
                fn($user) => $user->orders->isEmpty()
                ? [$this->mapUserData($user)]
                : $user->orders->map(fn($order) => $this->mapUserData($user, $order))
            );
        if (request()->has('excel')) {
            return (new FastExcel($data))->download('UserReport.xlsx');
        } elseif (request()->has('csv')) {
            return (new FastExcel($data))->download('UserReport.csv');
        } else {
            $pdf = Pdf::loadView('user.pdf.exportusers', ['users' => $data]);
            return $pdf->download('UserReport.pdf');
        }
    }

    private function mapUserData($user, $order = null)
    {
        return [

            'Name' => strtoupper($user->name),
            'Email' => $user->email,
            'Image' => $user->image ?? 'N/A',
            'Status' => $user->active_status ?? 'N/A',
            'Last Login IP' => request()->ip() ?? 'N/A',
            'Last Login Time' => now()->subHours(rand(1, 72))->format('M d, g:i A') ?? 'N/A',
            'Order Name' => $order->name ?? 'N/A',
            'Order Number' => $order->number ?? 'N/A',
            'Order Email' => $order->email ?? 'N/A',
            'Order Method' => $order->method ?? 'N/A',
            'Order Address' => $order->address ?? 'N/A',
            'Total Products' => $order->total_products ?? 'N/A',
            'Total Price' => $order->total_price ?? 'N/A',
            'Placed On' => $order->placed_on ? date('Y-M-d', strtotime($order->placed_on)) : 'N/A',
            'Payment Status' => $order->payment_status ?? 'N/A',
            'Address Line 1' => $user->Address->address_line_1 ?? 'N/A',
            'Address Line 2' => $user->Address->address_line_2 ?? 'N/A',
            'City' => $user->Address->city ?? 'N/A',
            'State' => $user->Address->state ?? 'N/A',
            'Country' => $user->Address->country ?? 'N/A',
            'Pincode' => $user->Address->pincode ?? 'N/A',
            'Phone Number' => $user->Address->phone_number ?? 'N/A',
        ];
    }

}