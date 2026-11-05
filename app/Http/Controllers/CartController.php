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
        $tax = 0;
        $total = 0;

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

        // Calculate tax (10%)
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        return view('cart.payment', compact(
            'cartItems',
            'subtotal',
            'tax',
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

        // Validate payment method
        $paymentMethod = $request->input('payment_method');
        $cashAmount = $request->input('cash_amount');

        if (!in_array($paymentMethod, ['cash', 'transfer', 'e_wallet'])) {
            return back()
                ->with('error', 'Metode pembayaran tidak valid!');
        }

        if ($paymentMethod === 'cash' && (!$cashAmount || $cashAmount < 0)) {
            return back()
                ->with('error', 'Jumlah uang tunai tidak valid!');
        }

        // Get cart items and calculate total
        $productIds = array_keys($cart);
        $products = Product::available()
            ->whereIn('id', $productIds)
            ->get();

        $cartItems = [];
        $totalAmount = 0;

        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            $subtotal = $product->price * $quantity;
            
            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
            
            $totalAmount += $subtotal;
        }

        // Calculate tax
        $tax = $totalAmount * 0.1;
        $finalAmount = $totalAmount + $tax;

        // For demo purposes, just clear cart and show success
        Session::forget('cart');

        return redirect()
            ->route('menu.index')
            ->with('success', 'Pembayaran berhasil! Terima kasih atas pesanan Anda.');
    }

    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        return count($cart);
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
