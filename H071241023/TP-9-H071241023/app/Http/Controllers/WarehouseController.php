<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchKeyword = $request->get('search');
        $warehouses = Warehouse::when($searchKeyword, function ($query) use ($searchKeyword) {
                $query->where('name', 'like', "%{$searchKeyword}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('warehouses.index', compact('warehouses', 'searchKeyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        Warehouse::create($validatedData);
        return redirect()->route('warehouses.index')->with('success', 'Warehouse berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        $warehouse->load(['products' => fn($query) => $query->withPivot('quantity')]);
        return view('warehouses.show', compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        $warehouse->update($validatedData);
        return redirect()->route('warehouses.index')->with('success', 'Warehouse berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Warehouse berhasil dihapus.');
    }
}