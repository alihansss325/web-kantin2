<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with('category')->available()->inStock();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->sort) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'featured':
                    $query->featured()->orderBy('sort_order', 'asc');
                    break;
                default:
                    $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
        }

        $products = $query->paginate(12);
        $categories = Category::active()->ordered()->get();
        $featuredProducts = Product::featured()->available()->inStock()->limit(6)->get();

        return view('menu.index', compact('products', 'categories', 'featuredProducts'));
    }

    public function show(Product $product)
    {
        if (!$product->canBeSold()) {
            abort(404, 'Menu tidak tersedia');
        }

        $relatedProducts = Product::with('category')
            ->available()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('menu.show', compact('product', 'relatedProducts'));
    }

    public function category(Category $category)
    {
        $products = Product::with('category')
            ->available()
            ->inStock()
            ->where('category_id', $category->id)
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(12);

        return view('menu.category', compact('products', 'category'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        
        if (empty($search)) {
            return redirect()->route('menu.index');
        }

        $products = Product::with('category')
            ->available()
            ->inStock()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(12);

        $categories = Category::active()->ordered()->get();

        return view('menu.search', compact('products', 'categories', 'search'));
    }

    public function featured()
    {
        $products = Product::with('category')
            ->featured()
            ->available()
            ->inStock()
            ->orderBy('sort_order', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(12);

        return view('menu.featured', compact('products'));
    }
}
