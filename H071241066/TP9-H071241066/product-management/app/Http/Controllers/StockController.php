<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\StockMovement; 

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        $products = Product::all(); 

        $selectedWarehouseId = $request->input('warehouse_id');
        $stocks = collect(); 

        if ($selectedWarehouseId) {
            $warehouse = Warehouse::with(['products' => function ($query) {
                $query->wherePivot('quantity', '>', 0); 
                $query->orderBy('name', 'asc');
            }])->findOrFail($selectedWarehouseId);
            
            $stocks = $warehouse->products; 
        }

        return view('stocks.index', compact('warehouses', 'stocks', 'products', 'selectedWarehouseId'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'stock_value' => 'required|integer|not_in:0', 
        ]);
        
        $warehouseId = $request->warehouse_id;
        $productId = $request->product_id;
        $transferValue = (int) $request->stock_value;
        
        $newStock = 0; 

        DB::transaction(function () use ($warehouseId, $productId, $transferValue, &$newStock) {
            
            $currentStock = DB::table('product_warehouse')
                            ->where('warehouse_id', $warehouseId)
                            ->where('product_id', $productId)
                            ->lockForUpdate() 
                            ->value('quantity') ?? 0;

            $newStock = $currentStock + $transferValue;

            if ($newStock < 0) {
                throw ValidationException::withMessages([
                    'stock_value' => 'Pengurangan stok (' . $transferValue . ') melebihi stok yang tersedia (' . $currentStock . '). Stok tidak boleh minus.'
                ]);
            }
            
            DB::table('product_warehouse')->updateOrInsert(
                [
                    'warehouse_id' => $warehouseId,
                    'product_id' => $productId
                ],
                [
                    'quantity' => $newStock,
                ]
            );

            StockMovement::create([
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'value' => $transferValue, 
                'stock_after' => $newStock,
                'notes' => 'Transfer Stok',
            ]);

        }); 
        
        return redirect()->route('stocks.index', ['warehouse_id' => $warehouseId])
                         ->with('success', 'Transfer stok berhasil. Stok baru: ' . $newStock);
    }

    public function history(Request $request)
    {
        $movements = StockMovement::with(['product', 'warehouse'])
            ->latest() 
            ->paginate(20); 

        return view('stocks.history', compact('movements'));
    }
}