<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'detail']); // Memuat relasi kategori dan detail produk

        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function($subQ) use ($search) { 
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.01', 
            'size' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) { 
            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
            ]);

            $product->detail()->create([
                'description' => $validated['description'] ?? null,
                'weight' => $validated['weight'],
                'size' => $validated['size'] ?? null,
            ]);
        });

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'detail', 'warehouses']);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('detail');
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.01', 
            'size' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $product) {
            $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'category_id' => $validated['category_id'],
            ]);

            $product->detail()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'description' => $validated['description'] ?? null,
                    'weight' => $validated['weight'],
                    'size' => $validated['size'] ?? null,
                ]
            );
        });

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->detail()->delete();
            $product->warehouses()->detach();
            $product->delete();
        });

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}