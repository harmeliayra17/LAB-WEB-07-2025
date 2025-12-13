<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockTransferController extends Controller
{
    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id'   => 'required|exists:products,id',
            'stock_change' => 'required|integer|not_in:0',
        ]);

        DB::transaction(function () use ($validatedData) {
            $warehouse = Warehouse::lockForUpdate()->find($validatedData['warehouse_id']);
            $productId = $validatedData['product_id'];
            $stockChange = (int) $validatedData['stock_change'];

            $existingStockRecord = $warehouse->products()->where('product_id', $productId)->first();
            $currentStock = $existingStockRecord ? $existingStockRecord->pivot->quantity : 0;
            $newStock = $currentStock + $stockChange;

            if (!$existingStockRecord && $stockChange < 0) {
                throw ValidationException::withMessages([
                    'stock_change' => 'Stok kosong, tidak bisa dikurangi.',
                ]);
            }

            if ($newStock < 0) {
                throw ValidationException::withMessages([
                    'stock_change' => 'Stok tidak boleh negatif.',
                ]);
            }

            if ($existingStockRecord) {
                $warehouse->products()->updateExistingPivot($productId, ['quantity' => $newStock]);
            } else {
                $warehouse->products()->attach($productId, ['quantity' => $newStock]);
            }
        });

        return redirect()
            ->route('stocks.index', ['warehouse_id' => $validatedData['warehouse_id']])
            ->with('success', 'Perubahan stok berhasil disimpan.');
    }
}