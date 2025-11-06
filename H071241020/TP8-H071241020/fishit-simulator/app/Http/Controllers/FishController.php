<?php

namespace App\Http\Controllers;

use App\Models\Fish; // Impor model Fish dari App\Models
use Illuminate\Http\Request;

class FishController extends Controller
{
    public function index(Request $request)
    {
        $query = Fish::query();

        // Filter berdasarkan rarity jika ada input
        if ($request->has('rarity') && $request->rarity != '') {
            $query->where('rarity', $request->rarity);
        }

        $fishes = $query->paginate(10); // Pagination 10 item per halaman

        return view('fishes.index', compact('fishes'));
    }

    public function create()
    {
        return view('fishes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string',
        ]);

        Fish::create($request->all()); // Sekarang akan mengenali model Fish
        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil ditambahkan');
    }

    public function show($id)
    {
        $fish = Fish::findOrFail($id);
        return view('fishes.show', compact('fish'));
    }

    public function edit($id)
    {
        $fish = Fish::findOrFail($id);
        return view('fishes.edit', compact('fish'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string',
        ]);

        $fish = Fish::findOrFail($id);
        $fish->update($request->all());
        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $fish = Fish::findOrFail($id);
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil dihapus');
    }
}
