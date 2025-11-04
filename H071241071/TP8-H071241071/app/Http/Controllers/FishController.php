<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fish;


class FishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Fish::query();

        $query->rarity($request->rarity);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sort = $request->sort ?? 'name';
        $direction = $request->direction ?? 'asc';
        if ($sort === 'price') {
            $query->orderBy('sell_price_per_kg', $direction);
        } elseif ($sort === 'probability') {
            $query->orderBy('catch_probability', $direction);
        } else {
            $query->orderBy('name', $direction);
        }

        $fishes = $query->paginate(10);

        return view('fishes.index', compact('fishes', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fishes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|between:0.01,100.00',
            'description' => 'nullable|string',
        ]);

        Fish::create($validated);

        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fish $fish)
    {
        return view('fishes.edit', compact('fish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fish $fish)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|between:0.01,100.00',
            'description' => 'nullable|string',
        ]);

        $fish->update($validated);

        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil dihapus.');
    }
}
