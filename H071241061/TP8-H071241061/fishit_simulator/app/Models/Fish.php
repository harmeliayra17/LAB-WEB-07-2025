<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    protected $table = 'fishes';
    
    protected $fillable = [ 
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description'
    ];

    protected $casts = [
        'base_weight_min' => 'decimal:2',
        'base_weight_max' => 'decimal:2',
        'catch_probability' => 'decimal:2'
    ];

    // Scope untuk filter berdasarkan rarity
    public function scopeByRarity($query, $rarity)
    {
        if ($rarity && $rarity !== '') {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }

    // Scope untuk search berdasarkan nama
    public function scopeSearch($query, $search)
    {
        if ($search && $search !== '') {
            return $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
        }
        return $query;
    }

    // Accessor untuk format harga
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->sell_price_per_kg, 0, ',', '.') . ' Coins/kg';
    }

    // Accessor untuk format berat
    public function getFormattedWeightRangeAttribute(): string
    {
        return number_format($this->base_weight_min, 2, ',', '.') . ' - ' . 
               number_format($this->base_weight_max, 2, ',', '.') . ' kg';
    }

    // Accessor untuk format probabilitas
    public function getFormattedProbabilityAttribute(): string
    {
        return number_format($this->catch_probability, 2, ',', '.') . '%';
    }

    // Method untuk mendapatkan warna badge berdasarkan rarity
    public function getRarityColorAttribute(): string
    {
        return match($this->rarity) {
            'Common' => 'bg-green-500',
            'Uncommon' => 'bg-blue-500',
            'Rare' => 'bg-purple-500',
            'Epic' => 'bg-pink-500',
            'Legendary' => 'bg-yellow-400',
            'Mythic' => 'bg-red-500',
            'Secret' => 'bg-gradient-to-r from-purple-500 via-pink-500 to-yellow-500',
            default => 'bg-gray-500'
        };
    }

    // Method untuk mendapatkan icon berdasarkan rarity
    public function getRarityIconAttribute(): string
    {
        return match($this->rarity) {
            'Common' => '🐟',
            'Uncommon' => '🐠',
            'Rare' => '🐡',
            'Epic' => '🦈',
            'Legendary' => '🐋',
            'Mythic' => '🦑',
            'Secret' => '🐉',
            default => '🐟'
        };
    }
}