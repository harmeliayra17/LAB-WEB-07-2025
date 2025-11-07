<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    public function index(Request $request)
    {
        $query = Fish::query();

        // Filter berdasarkan rarity
        if ($request->has('rarity') && $request->rarity != '') {
            $query->byRarity($request->rarity);
        }

        // Search berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['name', 'sell_price_per_kg', 'catch_probability', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $fishes = $query->paginate(10)->withQueryString();
        
        // Array untuk dropdown rarity
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];

        return view('fishes.index', compact('fishes', 'rarities'));
    }

    public function create()
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.create', compact('rarities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|min:0.01|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string'
        ], [
            'name.required' => 'Nama ikan wajib diisi',
            'name.max' => 'Nama ikan maksimal 100 karakter',
            'rarity.required' => 'Rarity wajib dipilih',
            'rarity.in' => 'Rarity tidak valid',
            'base_weight_min.required' => 'Berat minimum wajib diisi',
            'base_weight_min.numeric' => 'Berat minimum harus berupa angka',
            'base_weight_min.min' => 'Berat minimum minimal 0.01 kg',
            'base_weight_max.required' => 'Berat maksimum wajib diisi',
            'base_weight_max.numeric' => 'Berat maksimum harus berupa angka',
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum',
            'sell_price_per_kg.required' => 'Harga jual wajib diisi',
            'sell_price_per_kg.integer' => 'Harga jual harus berupa angka bulat',
            'sell_price_per_kg.min' => 'Harga jual minimal 0',
            'catch_probability.required' => 'Peluang tangkap wajib diisi',
            'catch_probability.numeric' => 'Peluang tangkap harus berupa angka',
            'catch_probability.min' => 'Peluang tangkap minimal 0.01%',
            'catch_probability.max' => 'Peluang tangkap maksimal 100%'
        ]);

        Fish::create($validated); //simpan data hasil validasi ke database

        return redirect()->route('fishes.index')
            ->with('success', '🎣 Ikan berhasil ditambahkan ke database!');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    public function edit(Fish $fish)
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    public function update(Request $request, Fish $fish)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|min:0.01|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string'
        ], [
            'name.required' => 'Nama ikan wajib diisi',
            'name.max' => 'Nama ikan maksimal 100 karakter',
            'rarity.required' => 'Rarity wajib dipilih',
            'rarity.in' => 'Rarity tidak valid',
            'base_weight_min.required' => 'Berat minimum wajib diisi',
            'base_weight_min.numeric' => 'Berat minimum harus berupa angka',
            'base_weight_min.min' => 'Berat minimum minimal 0.01 kg',
            'base_weight_max.required' => 'Berat maksimum wajib diisi',
            'base_weight_max.numeric' => 'Berat maksimum harus berupa angka',
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum',
            'sell_price_per_kg.required' => 'Harga jual wajib diisi',
            'sell_price_per_kg.integer' => 'Harga jual harus berupa angka bulat',
            'sell_price_per_kg.min' => 'Harga jual minimal 0',
            'catch_probability.required' => 'Peluang tangkap wajib diisi',
            'catch_probability.numeric' => 'Peluang tangkap harus berupa angka',
            'catch_probability.min' => 'Peluang tangkap minimal 0.01%',
            'catch_probability.max' => 'Peluang tangkap maksimal 100%'
        ]);

        $fish->update($validated);

        return redirect()->route('fishes.index')
            ->with('success', '✅ Data ikan berhasil diupdate!');
    }

    public function destroy(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('fishes.index')
            ->with('success', '🗑️ Ikan berhasil dihapus dari database!');
    }
}