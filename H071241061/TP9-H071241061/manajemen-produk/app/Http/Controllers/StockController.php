<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        $selectedWarehouse = null;
        $stocks = collect();

        if ($request->filled('warehouse_id')) {
            $selectedWarehouse = Warehouse::findOrFail($request->warehouse_id);
            
            $stocks = $selectedWarehouse->products()
                ->with('category')
                ->get();
        }

        return view('stocks.index', compact('warehouses', 'selectedWarehouse', 'stocks'));
    }

    public function transfer(Request $request)
    {
        $warehouses = Warehouse::all();
        $products = Product::with('category')->get();
        
        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function storeTransfer(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0',
        ]);

        //load data warehouse dan product
        $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
        $product = Product::findOrFail($validated['product_id']);
        $quantity = $validated['quantity'];

        try {
            DB::transaction(function () use ($warehouse, $product, $quantity) {
                // Cek stok saat ini
                $currentStock = $warehouse->products()
                    ->where('product_id', $product->id)
                    ->first();

                $currentQuantity = $currentStock ? $currentStock->pivot->quantity : 0;
                $newQuantity = $currentQuantity + $quantity;

                // Validasi: jangan sampai stok minus
                if ($newQuantity < 0) {
                    throw new \Exception('Stok tidak boleh kurang dari 0. Stok saat ini: ' . $currentQuantity);
                }

                // Update atau create stok
                if ($currentStock) {
                    $warehouse->products()->updateExistingPivot(
                        $product->id,
                        ['quantity' => $newQuantity]
                    );
                } else {
                    // Jika belum ada record dan quantity negatif, tolak
                    if ($quantity < 0) {
                        throw new \Exception('Tidak dapat mengurangi stok produk yang belum ada di gudang.');
                    }
                    $warehouse->products()->attach($product->id, ['quantity' => $quantity]);
                }
            });

            return redirect()->route('stocks.index', ['warehouse_id' => $validated['warehouse_id']])
                ->with('success', 'Transfer stok berhasil dilakukan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}