<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rarity = $request->query('rarity');
        $search = $request->query('search');
        $sort = $request->query('sort', 'name');
        $order = $request->query('order', 'asc');

        $sortable = ['name', 'sell_price_per_kg', 'catch_probability'];
        if (!in_array($sort, $sortable)) {
            $sort = 'name';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        $fishes = Fish::query() 
            ->rarity($rarity)
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy($sort, $order)
            ->paginate(10)
            ->withQueryString();

        $rarities = [
            'Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'
        ];
        return view('fishes.index', compact('fishes', 'rarities', 'rarity', 'search', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rarities = [
            'Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'
        ];
        return view('fishes.create', compact('rarities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        $data = $request->validate([
            'name'               => 'required|string|max:100',
            'rarity'             => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min'    => 'required|numeric',
            'base_weight_max'    => 'required|numeric|gte:base_weight_min',
            'sell_price_per_kg'  => 'required|integer|min:0',
            'catch_probability'  => 'required|numeric|min:0|max:100', 
            'description'        => 'nullable|string',
        ], [
            'base_weight_max.gte' => 'Berat maksimum ikan harus lebih besar dari berat minimum ikan.',
        ]);

        Fish::create([
            'name'               => $data['name'],
            'rarity'             => $data['rarity'],
            'base_weight_min'    => $data['base_weight_min'],
            'base_weight_max'    => $data['base_weight_max'],
            'sell_price_per_kg'  => $data['sell_price_per_kg'], 
            'catch_probability'  => $data['catch_probability'],
            'description'        => $data['description'] ?? null,
        ]);

        return redirect()->route('fishes.index')->with('success','Saved!');
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
        $rarities = [
            'Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'
        ];
        return view('fishes.edit', compact('fish','rarities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fish $fish) 
    {
        $data = $request->validate([
            'name'               => 'required|string|max:100',
            'rarity'             => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min'    => 'required|numeric',
            'base_weight_max'    => 'required|numeric|gte:base_weight_min',
            'sell_price_per_kg'  => 'required|integer|min:0',
            'catch_probability'  => 'required|numeric|min:0|max:100',
            'description'        => 'nullable|string',
        ], [
            'base_weight_max.gte' => 'Berat maksimum ikan harus lebih besar dari berat minimum ikan.',
        ]);

        $fish->update([
            'name'               => $data['name'],
            'rarity'             => $data['rarity'],
            'base_weight_min'    => $data['base_weight_min'],
            'base_weight_max'    => $data['base_weight_max'],
            'sell_price_per_kg'  => $data['sell_price_per_kg'],
            'catch_probability'  => $data['catch_probability'],
            'description'        => $data['description'] ?? null,
        ]);

        return redirect()->route('fishes.index')->with('success','Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Fish deleted successfully.');
    }
}