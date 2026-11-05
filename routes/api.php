<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Routes untuk mobile app atau external integrations
Route::prefix('v1')->group(function () {
    // Authentication API
    Route::post('/login', function (Request $request) {
        // API Login logic
        return response()->json(['token' => 'api-token']);
    });

    // Products API
    Route::get('/products', function (Request $request) {
        $products = \App\Models\Product::with('category')
            ->available()
            ->inStock()
            ->when($request->category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(12);

        return response()->json($products);
    });

    // Categories API
    Route::get('/categories', function () {
        $categories = \App\Models\Category::active()->ordered()->get();
        return response()->json($categories);
    });

    // Cart API (authenticated)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/cart', function () {
            $cart = session('cart', []);
            return response()->json($cart);
        });

        Route::post('/cart/add/{product}', function (\App\Models\Product $product, Request $request) {
            // Add to cart logic
            return response()->json(['message' => 'Added to cart']);
        });
    });
});
