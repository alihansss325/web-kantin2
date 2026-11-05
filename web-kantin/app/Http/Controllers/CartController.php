<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $subtotal = 0;
        $tax = 0;
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::with('category')
                ->available()
                ->whereIn('id', $productIds)
                ->get();

            foreach ($products as $product) {
                $quantity = $cart[$product->id]['quantity'];
                $itemSubtotal = $product->price * $quantity;
                
                $cartItems[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->image,
                    'category' => $product->category->name ?? null,
                    'subtotal' => $itemSubtotal,
                ];
                
                $subtotal += $itemSubtotal;
            }
        }

        // Calculate tax (10%)
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        return view('cart.simple', compact(
            'cartItems',
            'subtotal',
            'tax',
            'total'
        ));
    }

    public function add(Request $request, Product $product)
    {
        // Check if product is available and has stock
        if ($product->status !== 'available' || $product->stock <= 0) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak tersedia atau stok habis!'
                ]);
            }
            return back()
                ->with('error', 'Menu tidak tersedia atau stok habis!');
        }

        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah pesanan tidak valid!'
                ]);
            }
            return back()
                ->with('error', 'Jumlah pesanan tidak valid!');
        }

        if ($quantity > $product->stock) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok tidak mencukupi! Stok tersedia: {$product->stock}"
                ]);
            }
            return back()
                ->with('error', "Stok tidak mencukupi! Stok tersedia: {$product->stock}");
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            
            if ($newQuantity > $product->stock) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok tidak mencukupi! Stok tersedia: {$product->stock}"
                    ]);
                }
                return back()
                    ->with('error', "Stok tidak mencukupi! Stok tersedia: {$product->stock}");
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $quantity,
                'added_at' => now()->timestamp,
            ];
        }

        Session::put('cart', $cart);

        $message = $quantity > 1 
            ? "{$quantity} {$product->name} ditambahkan ke keranjang!"
            : "{$product->name} ditambahkan ke keranjang!";

        // Return JSON response for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => count($cart)
            ]);
        }

        return back()
            ->with('success', $message);
    }

    public function update(Request $request, Product $product)
    {
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            return $this->remove($product);
        }

        if ($quantity > $product->stock) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok tidak mencukupi! Stok tersedia: {$product->stock}"
                ]);
            }
            return back()
                ->with('error', "Stok tidak mencukupi! Stok tersedia: {$product->stock}");
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }

        // Return JSON response for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jumlah pesanan diperbarui!',
                'cart_count' => count($cart)
            ]);
        }

        return back()
            ->with('success', 'Jumlah pesanan diperbarui!');
    }

    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            Session::put('cart', $cart);
        }

        // Return JSON response for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu dihapus dari keranjang!',
                'cart_count' => count($cart)
            ]);
        }

        return back()
            ->with('success', 'Menu dihapus dari keranjang!');
    }

    public function clear()
    {
        Session::forget('cart');

        return back()
            ->with('success', 'Keranjang dikosongkan!');
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang belanja kosong!');
        }

        // Get cart items and calculate totals
        $cartItems = [];
        $subtotal = 0;

        $productIds = array_keys($cart);
        $products = Product::with('category')
            ->available()
            ->whereIn('id', $productIds)
            ->get();

        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            
            // Check stock availability
            if ($product->stock < $quantity) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', "Stok {$product->name} tidak mencukupi! Tersedia: {$product->stock}");
            }
            
            $itemSubtotal = $product->price * $quantity;
            
            $cartItems[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'category' => $product->category->name ?? null,
                'subtotal' => $itemSubtotal,
            ];
            
            $subtotal += $itemSubtotal;
        }

        $total = $subtotal;

        return view('cart.checkout', compact(
            'cartItems',
            'subtotal',
            'total'
        ));
    }

    public function processCheckout(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang belanja kosong!');
        }

        // Validate customer data
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_class' => 'required|string|max:50',
            'table_number' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Nama pemesan harus diisi',
            'customer_class.required' => 'Kelas harus diisi',
        ]);

        try {
            DB::beginTransaction();

            // Get cart items and validate stock
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate() // Lock rows to prevent race condition
                ->get()
                ->keyBy('id');

            $orderItems = [];
            $totalAmount = 0;

            foreach ($cart as $productId => $cartItem) {
                $product = $products->get($productId);
                
                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan");
                }

                if ($product->status !== 'available') {
                    throw new \Exception("{$product->name} tidak tersedia");
                }

                $quantity = $cartItem['quantity'];

                if ($product->stock < $quantity) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi! Tersedia: {$product->stock}");
                }

                $subtotal = $product->price * $quantity;
                
                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
                
                $totalAmount += $subtotal;

                // Decrease stock
                $product->decrement('stock', $quantity);
            }

            // Create order
            $order = \App\Models\Order::create([
                'order_number' => \App\Models\Order::generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_class' => $validated['customer_class'],
                'table_number' => $validated['table_number'] ?? null,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            DB::commit();

            // Clear cart
            Session::forget('cart');

            return redirect()
                ->route('cart.confirmation', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        return response()->json(['count' => count($cart)]);
    }

    public function confirmation($orderId)
    {
        $order = \App\Models\Order::with('items.product')->findOrFail($orderId);
        
        return view('cart.confirmation', compact('order'));
    }

    public function getCartTotal()
    {
        $cart = Session::get('cart', []);
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::available()
                ->whereIn('id', $productIds)
                ->get();

            foreach ($products as $product) {
                $quantity = $cart[$product->id]['quantity'];
                $total += $product->price * $quantity;
            }
        }

        return $total;
    }
}
