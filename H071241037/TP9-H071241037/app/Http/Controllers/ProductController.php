<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10); 
        return view('products.index', compact('products'));
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
            'price' => 'required|numeric|min:0|decimal:0,2', 
            'category_id' => 'nullable|exists:categories,id', 
            'description' => 'nullable|string', 
            'weight' => 'required|numeric|min:0|decimal:0,2', 
            'size' => 'nullable|string|max:255', 
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $product = Product::create([
                    'name' => $validated['name'],
                    'price' => $validated['price'],
                    'category_id' => $validated['category_id'],
                ]);

                $product->detail()->create([ 
                    'description' => $validated['description'],
                    'weight' => $validated['weight'],
                    'size' => $validated['size'],
                ]);
            }); 

            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }
   
    public function show(Product $product)
    {
        $product->load(['detail', 'category']); 
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('detail'); 
        $categories = Category::all(); 
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|decimal:0,2',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0|decimal:0,2',
            'size' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($validated, $product) {
                $product->update([
                    'name' => $validated['name'],
                    'price' => $validated['price'],
                    'category_id' => $validated['category_id'],
                ]);

                $product->detail()->updateOrCreate(
                    ['product_id' => $product->id], 
                    [
                        'description' => $validated['description'],
                        'weight' => $validated['weight'],
                        'size' => $validated['size'],
                    ] 
                );
            }); 

            return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}