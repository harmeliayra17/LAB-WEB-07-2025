<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller {
    public function index() {
        $warehouses = Warehouse::paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }

    public function create() {
        return view('warehouses.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        Warehouse::create($request->all());
        return redirect()->route('warehouses.index');
    }

    public function edit(Warehouse $warehouse) {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse) {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        $warehouse->update($request->all());
        return redirect()->route('warehouses.index');
    }

    public function destroy(Warehouse $warehouse) {
        $warehouse->delete();
        return redirect()->route('warehouses.index');
    }
}