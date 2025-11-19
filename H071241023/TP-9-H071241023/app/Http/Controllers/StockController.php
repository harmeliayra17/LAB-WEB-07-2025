<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $selectedWarehouseId = $request->get('warehouse_id');
        $warehouses = Warehouse::orderBy('name')->get();
        $productsInWarehouse = collect();

        if ($selectedWarehouseId) {
            $selectedWarehouse = Warehouse::findOrFail($selectedWarehouseId);
            $productsInWarehouse = $selectedWarehouse->products()
                ->with('category')
                ->withPivot('quantity')
                ->orderBy('name')
                ->get();
        }
        
        return view('stocks.index', compact('warehouses', 'selectedWarehouseId', 'productsInWarehouse'));
    }
}