<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchKeyword = $request->get('search');
        $products = Product::with('category')
            ->when($searchKeyword, function ($query) use ($searchKeyword) {
                $query->where('name', 'like', "%{$searchKeyword}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products', 'searchKeyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight'      => 'required|numeric|min:0',
            'size'        => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData) {
            $product = Product::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'category_id' => $validatedData['category_id'] ?? null,
            ]);

            $product->detail()->create([
                'description' => $validatedData['description'] ?? null,
                'weight' => $validatedData['weight'],
                'size' => $validatedData['size'] ?? null,
            ]);
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'detail', 'warehouses' => fn($query) => $query->withPivot('quantity')]);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('detail');
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight'      => 'required|numeric|min:0',
            'size'        => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($product, $validatedData) {
            $product->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'category_id' => $validatedData['category_id'] ?? null,
            ]);

            $product->detail()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'description' => $validatedData['description'] ?? null,
                    'weight' => $validatedData['weight'],
                    'size' => $validatedData['size'] ?? null,
                ]
            );
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}