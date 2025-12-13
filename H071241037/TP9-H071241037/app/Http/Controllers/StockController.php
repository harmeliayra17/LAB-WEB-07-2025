<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        $products = Product::orderBy('name')->get();

        $selectedWarehouseId = $request->input('warehouse_id');
        $stockData = [];

        $query = Warehouse::with('products');

        if ($selectedWarehouseId) {
            $query->where('id', $selectedWarehouseId); 
        }

        $stockData = $query->get();

        return view('stocks.index', compact('warehouses', 'products', 'stockData', 'selectedWarehouseId'));
    }

    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0', 
        ]);

        $warehouse = Warehouse::find($validated['warehouse_id']);
        $productId = $validated['product_id'];
        $quantityChange = $validated['quantity'];

        $productInWarehouse = $warehouse->products()->find($productId);

        $currentQuantity = $productInWarehouse ? $productInWarehouse->pivot->quantity : 0;

        $newQuantity = $currentQuantity + $quantityChange;

        if ($newQuantity < 0) {
            return back()->with('error', 'Stok tidak mencukupi! Stok saat ini: ' . $currentQuantity);
        }

        $warehouse->products()->syncWithoutDetaching([
            $productId => ['quantity' => $newQuantity]
        ]);

        return redirect()->route('stocks.index', ['warehouse_id' => $warehouse->id])
                         ->with('success', 'Stok berhasil diperbarui.');
    }
}