<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    /**
     * Display a listing of the resource 
     */
    public function index(Request $request)
    {
        $query = Fish::query();
        
        // implmen scope
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        if ($request->filled('rarity')) {
            $query->rarity($request->rarity);
        }
        
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->sortByName();
                    break;
                case 'name_desc':
                    $query->sortByName('desc');
                    break;
                case 'price_asc':
                    $query->sortByPrice();
                    break;
                case 'price_desc':
                    $query->sortByPrice('desc');
                    break;
                case 'probability_asc':
                    $query->sortByProbability();
                    break;
                case 'probability_desc':
                    $query->sortByProbability('desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $fishes = $query->paginate(3);
        
        return view('fishes.index', compact('fishes'));
    }

    public function create()
    {
        return view('fishes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0|max:99999999.99',
            'base_weight_max' => 'required|numeric|gt:base_weight_min|max:99999999.99',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string'
        ], [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum',
            'base_weight_min.max_digits' => 'Berat minimum tidak boleh lebih dari 8 digit',
            'base_weight_max.max_digits' => 'Berat maksimum tidak boleh lebih dari 8 digit',
            'catch_probability.min' => 'Peluang tangkap minimal 0.01%',
            'catch_probability.max' => 'Peluang tangkap maksimal 100%'
        ]);

        Fish::create($validated);

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan berhasil ditambahkan! 🎣');
    }

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
            'base_weight_min' => 'required|numeric|min:0|max:99999999.99',
            'base_weight_max' => 'required|numeric|gt:base_weight_min|max:99999999.99',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string'
        ], [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum',
            'base_weight_min.max_digits' => 'Berat minimum tidak boleh lebih dari 8 digit',
            'base_weight_max.max_digits' => 'Berat maksimum tidak boleh lebih dari 8 digit',
            'catch_probability.min' => 'Peluang tangkap minimal 0.01%',
            'catch_probability.max' => 'Peluang tangkap maksimal 100%'
        ]);

        $fish->update($validated);

        return redirect()->route('fishes.show', $fish->id)
            ->with('success', 'Ikan berhasil diupdate! ✏️');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fish $fish)
    {
        $fishName = $fish->name;
        $fish->delete();

        return redirect()->route('fishes.index')
            ->with('success', "Ikan {$fishName} berhasil dihapus! 🗑️");
    }
}