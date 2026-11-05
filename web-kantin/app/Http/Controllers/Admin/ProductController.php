<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->get();
        $categories = Category::active()->ordered()->get();

        return view('admin.products', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,unavailable',
            'is_featured' => 'boolean',
            'is_taxable' => 'boolean',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_taxable'] = $request->has('is_taxable');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $imageName);
            $data['image'] = 'products/' . $imageName;
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'transactionItems', 'inventoryLogs']);
        return view('admin.products.show', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,unavailable',
            'is_featured' => 'boolean',
            'is_taxable' => 'boolean',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_taxable'] = $request->has('is_taxable');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path('storage/' . $product->image))) {
                unlink(public_path('storage/' . $product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $imageName);
            $data['image'] = 'products/' . $imageName;
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->transactionItems()->count() > 0) {
            return back()
                ->with('error', 'Tidak dapat menghapus menu yang memiliki transaksi!');
        }

        if ($product->image) {
            $imagePath = public_path('storage/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Menu berhasil dihapus!');
    }

    public function toggleStatus(Product $product)
    {
        $newStatus = $product->status === 'available' ? 'unavailable' : 'available';
        $product->update(['status' => $newStatus]);
        
        $statusText = $newStatus === 'available' ? 'diaktifkan' : 'dinonaktifkan';
        
        return back()
            ->with('success', "Menu berhasil {$statusText}!");
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        
        $status = $product->is_featured ? 'ditandai sebagai unggulan' : 'dihapus dari unggulan';
        
        return back()
            ->with('success', "Menu berhasil {$status}!");
    }

    public function stockUpdate(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'stock' => 'required|integer|min:0',
            'reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $previousStock = $product->stock;
        $newStock = $request->stock;
        $quantityChange = $newStock - $previousStock;
        $action = $quantityChange >= 0 ? 'in' : 'out';

        $product->update(['stock' => $newStock]);

        $product->inventoryLogs()->create([
            'user_id' => auth()->id(),
            'action' => 'adjustment',
            'previous_stock' => $previousStock,
            'quantity_change' => $quantityChange,
            'new_stock' => $newStock,
            'reason' => $request->reason,
        ]);

        return back()
            ->with('success', 'Stok berhasil diperbarui!');
    }
}
