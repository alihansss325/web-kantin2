<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items.product']);

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        } else {
            // Default: today's orders
            $query->whereDate('created_at', today());
        }

        // Search by order number or customer name
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_class', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->latest()->paginate(20);

        // Statistics
        $stats = [
            'today_orders' => Order::today()->count(),
            'today_revenue' => Order::today()->where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending' => Order::today()->pending()->count(),
            'processing' => Order::today()->processing()->count(),
            'ready' => Order::today()->ready()->count(),
            'completed' => Order::today()->completed()->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product']);
        
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui!',
                'status' => $order->status,
                'status_label' => $order->status_label,
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function cancel(Order $order)
    {
        if ($order->status === 'completed') {
            return back()->with('error', 'Pesanan yang sudah selesai tidak dapat dibatalkan!');
        }

        // Return stock
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan!');
    }

    public function print(Order $order)
    {
        $order->load(['items.product']);
        
        return view('admin.orders.print', compact('order'));
    }
}
