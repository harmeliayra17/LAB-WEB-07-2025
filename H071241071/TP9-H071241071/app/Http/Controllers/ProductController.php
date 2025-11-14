<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;

class ProductController extends Controller {
    public function index() {
        $products = Product::with('category')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create() {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        $product = Product::create($request->only(['name', 'price', 'category_id']));

        ProductDetail::create([
            'product_id' => $product->id,
            'description' => $request->description,
            'weight' => $request->weight,
            'size' => $request->size,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk dibuat.');
    }

    public function show(Product $product) {
        $product->load('category', 'detail', 'warehouses');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product) {
        $categories = Category::all();
        $product->load('detail');
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        $product->update($request->only(['name', 'price', 'category_id']));
        $product->detail()->updateOrCreate(
            ['product_id' => $product->id],
            $request->only(['description', 'weight', 'size'])
        );

        return redirect()->route('products.index');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index');
    }
}