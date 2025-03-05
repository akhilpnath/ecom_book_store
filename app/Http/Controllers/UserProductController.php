<?php
namespace App\Http\Controllers;
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
            $query->where(function($q) use ($search) {
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
                case 'Under $25':
                    $query->where('price', '<', 25);
                    break;
                case '$25 - $50':
                    $query->whereBetween('price', [25, 50]);
                    break;
                case 'Over $50':
                    $query->where('price', '>', 50);
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
        $products = $query->paginate(8);
        
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