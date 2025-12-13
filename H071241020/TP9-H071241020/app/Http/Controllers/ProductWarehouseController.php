<?php
namespace App\Http\Controllers;

use App\Models\ProductWarehouse;
use Illuminate\Http\Request;

class ProductWarehouseController extends Controller
{
    public function index()
    {
        $productWarehouses = ProductWarehouse::with('product', 'warehouse')->get();
        return view('product-warehouse.index', compact('productWarehouses'));
    }

    public function create()
    {
        return view('product-warehouse.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:0',
        ]);

        // Simpan data ke pivot tabel
        $product = \App\Models\Product::findOrFail($request->product_id);
        $product->warehouses()->attach($request->warehouse_id, ['quantity' => $request->quantity]);

        return redirect()->route('product-warehouse.index')->with('success', 'Stok gudang berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $productWarehouse = ProductWarehouse::with('product', 'warehouse')->findOrFail($id);
        return view('product-warehouse.edit', compact('productWarehouse'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $productWarehouse = ProductWarehouse::findOrFail($id);
        $productWarehouse->update($request->all());
        return redirect()->route('product-warehouse.index')->with('success', 'Stok berhasil diperbarui');
    }

    public function show($id)
    {
        $productWarehouse = ProductWarehouse::with('product', 'warehouse')->findOrFail($id);
        return view('product-warehouse.show', compact('productWarehouse'));
    }

    public function destroy($id)
    {
        $productWarehouse = ProductWarehouse::findOrFail($id);
        $productWarehouse->delete();
        return redirect()->route('product-warehouse.index')->with('success', 'Stok berhasil dihapus');
    }
}
