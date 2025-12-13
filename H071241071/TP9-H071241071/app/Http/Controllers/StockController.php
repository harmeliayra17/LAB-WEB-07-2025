<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StockController extends Controller {
    public function index(Request $request) {
        $warehouseId = $request->get('warehouse_id');
        $warehouses = Warehouse::all();

        $query = Product::with(['warehouses' => function ($q) use ($warehouseId) {
            if ($warehouseId) $q->where('warehouse_id', $warehouseId);
        }]);

        if ($warehouseId) {
            $query->whereHas('warehouses', function ($q) use ($warehouseId) {
                $q->where('warehouse_id', $warehouseId);
            });
        }

        $products = $query->paginate(10)->appends($request->query());

        return view('stocks.index', compact('products', 'warehouses', 'warehouseId'));
    }

    public function transferForm() {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function transfer(Request $request) {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        $warehouse = Warehouse::findOrFail($request->warehouse_id);
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $pivot = DB::table('product_warehouse')
            ->where('product_id', $product->id)
            ->where('warehouse_id', $warehouse->id)
            ->first();

        $current = $pivot ? $pivot->quantity : 0;
        $newQuantity = $current + $quantity;

        if ($newQuantity < 0) {
            return back()->withErrors(['quantity' => 'Stok tidak boleh minus!']);
        }

        if ($newQuantity == 0 && $pivot) {
            DB::table('product_warehouse')
                ->where('product_id', $product->id)
                ->where('warehouse_id', $warehouse->id)
                ->delete();
        } else {
            DB::table('product_warehouse')->updateOrInsert(
                ['product_id' => $product->id, 'warehouse_id' => $warehouse->id],
                ['quantity' => $newQuantity, 'updated_at' => now()]
            );
        }

        return redirect()->route('stocks.index')->with('success', 'Stok berhasil diperbarui.');
    }
}