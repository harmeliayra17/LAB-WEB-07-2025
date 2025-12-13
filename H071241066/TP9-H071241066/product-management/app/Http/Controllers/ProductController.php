<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'detail'])->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'nullable|exists:categories,id',
            
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.01',
            'size' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            $product->detail()->create([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size,
            ]);
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('detail'); 
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.01',
            'size' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $product) {
            
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            $product->detail->update([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size,
            ]);
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'detail', 'warehouses', 'movements.warehouse']); //nested realation
        return view('products.show', compact('product'));
    }
    
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->detail()->delete();
            $product->warehouses()->detach(); 
            $product->delete();
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}