<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Topup;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySales = Transaction::today()->paid()->sum('final_amount');
        $todayTransactions = Transaction::today()->paid()->count();
        $totalProducts = Product::count();
        $activeProducts = Product::available()->count();
        $lowStockProducts = Product::lowStock()->count();
        $totalStudents = User::siswa()->active()->count();
        $todayTopups = Topup::today()->approved()->sum('amount');

        $recentTransactions = Transaction::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentTopups = Topup::with('user')
            ->approved()
            ->latest()
            ->limit(5)
            ->get();

        $lowStockItems = Product::lowStock()
            ->with('category')
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        $salesChart = Transaction::selectRaw('DATE(transaction_date) as date, SUM(final_amount) as total')
            ->where('transaction_date', '>=', now()->subDays(7))
            ->where('status', 'paid')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'todaySales',
            'todayTransactions',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'totalStudents',
            'todayTopups',
            'recentTransactions',
            'recentTopups',
            'lowStockItems',
            'salesChart'
        ));
    }
}
