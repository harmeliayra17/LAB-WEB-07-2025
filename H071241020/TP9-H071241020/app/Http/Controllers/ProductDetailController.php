<?php
namespace App\Http\Controllers;

use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function index()
    {
        $productDetails = ProductDetail::with('product')->get();
        return view('product-details.index', compact('productDetails'));
    }

    public function create()
    {
        return view('product-details.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:product_details,product_id',
            'description' => 'nullable',
            'weight' => 'required|numeric',
            'size' => 'nullable|max:255',
        ]);

        ProductDetail::create($request->all());
        return redirect()->route('product-details.index')->with('success', 'Detail produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $productDetail = ProductDetail::with('product')->findOrFail($id);
        return view('product-details.edit', compact('productDetail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'nullable',
            'weight' => 'required|numeric',
            'size' => 'nullable|max:255',
        ]);

        $productDetail = ProductDetail::findOrFail($id);
        $productDetail->update($request->all());
        return redirect()->route('product-details.index')->with('success', 'Detail produk berhasil diperbarui');
    }

    public function show($id)
    {
        $productDetail = ProductDetail::with('product')->findOrFail($id);
        return view('product-details.show', compact('productDetail'));
    }

    public function destroy($id)
    {
        $productDetail = ProductDetail::findOrFail($id);
        $productDetail->delete();
        return redirect()->route('product-details.index')->with('success', 'Detail produk berhasil dihapus');
    }
}
