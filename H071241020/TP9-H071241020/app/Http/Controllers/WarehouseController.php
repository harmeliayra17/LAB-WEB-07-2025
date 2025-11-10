<?php
namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('products')->get();
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'location' => 'nullable',
        ]);

        Warehouse::create($request->all());
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $warehouse = Warehouse::with('products')->findOrFail($id);
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'location' => 'nullable',
        ]);

        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update($request->all());
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil diperbarui');
    }

    public function show($id)
    {
        $warehouse = Warehouse::with('products')->findOrFail($id);
        return view('warehouses.show', compact('warehouse'));
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil dihapus');
    }
}
