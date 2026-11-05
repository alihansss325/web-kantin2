<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', '!=', 'cancelled')
                ->sum('total_amount'),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'available')->count(),
            'low_stock_products' => Product::whereRaw('stock <= min_stock')->count(),
            'total_categories' => Category::where('is_active', true)->count(),
        ];

        // Recent orders
        $recentOrders = Order::with('items')
            ->latest()
            ->limit(10)
            ->get();

        // Low stock products
        $lowStockProducts = Product::with('category')
            ->whereRaw('stock <= min_stock')
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        // Sales chart data (last 7 days)
        $salesChart = Order::selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_amount) as revenue')
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', '!=', 'cancelled')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'lowStockProducts',
            'salesChart'
        ));
    }
}
