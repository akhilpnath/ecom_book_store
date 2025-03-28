<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class UserProductController extends Controller
{
    public function shop(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('details', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Price range filter
        if ($request->has('price_range') && !empty($request->price_range)) {
            switch ($request->price_range) {
                case 'Under $200':
                    $query->where('price', '<', 200);
                    break;
                case '$200 - $500':
                    $query->whereBetween('price', [200, 500]);
                    break;
                case '$500 - $1000':
                    $query->whereBetween('price', [500, 1000]);
                    break;
                case '$1000 - $3000':
                    $query->whereBetween('price', [1000, 3000]);
                    break;
                case 'Over $3000':
                    $query->where('price', '>', 3000);
                    break;
            }
        }


        // Sorting
        if ($request->has('sort_by') && !empty($request->sort_by)) {
            switch ($request->sort_by) {
                case 'Price: Low to High':
                    $query->orderBy('price', 'asc');
                    break;
                case 'Price: High to Low':
                    $query->orderBy('price', 'desc');
                    break;
                case 'Newest First':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc'); // Default sort
        }

        // Get paginated results (8 per page)
        $products = $query->paginate(12);

        // Get all unique categories
        $categories = Product::pluck('category')->unique()->filter()->values();

        // Pass all request parameters for maintaining state in pagination links
        $products->appends($request->all());

        return view('user.shop', compact('products', 'categories'));
    }

    public function category($category)
    {
        $products = Product::where('category', $category)->paginate(8);
        return view('user.category', compact('products', 'category'));
    }

    public function view($id)
    {
        $product = Product::findOrFail($id);
        return view('user.product.view', compact('product'));
    }
}