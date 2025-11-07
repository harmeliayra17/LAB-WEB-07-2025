<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    private $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];

    public function index(Request $request)
    {
        $query = Fish::query();

        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $fishes = $query->latest()->paginate(10); 
        $rarities = $this->rarities;

        return view('fishes.index', compact('fishes', 'rarities'));
    }

    public function create()
    {
        $rarities = $this->rarities;
        return view('fishes.create', compact('rarities'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:' . implode(',', $this->rarities),
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min', 
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100', 
            'description' => 'nullable|string', 
        ]);

        Fish::create($request->all());

        return redirect()->route('fishes.index')
                         ->with('success', 'Fish created successfully!');
    }

   
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

   
    public function edit(Fish $fish)
    {
        $rarities = $this->rarities;
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    
    public function update(Request $request, Fish $fish)
    {

        $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:' . implode(',', $this->rarities),
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min', 
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100', 
            'description' => 'nullable|string',
        ]);

        $fish->update($request->all());

        return redirect()->route('fishes.index')
                         ->with('success', 'Fish updated successfully!');
    }

    
    public function destroy(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('fishes.index')
                         ->with('success', 'Fish deleted successfully!');
    }
}