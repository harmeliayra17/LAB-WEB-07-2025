<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'description',
    ];

    protected $casts = [
        'base_weight_min' => 'decimal:2',
        'base_weight_max' => 'decimal:2',
        'catch_probability' => 'decimal:2',
    ];

    /** Scope filter rarity */
    public function scopeRarity(Builder $q, ?string $rarity): Builder
    {
        return $rarity ? $q->where('rarity', $rarity) : $q;
    }

    /** Accessor format harga */
    public function getSellPricePerKgFormattedAttribute(): string
    {
        return number_format($this->sell_price_per_kg, 0, ',', '.').' Coins/kg';
    }

    /** Accessor format rentang berat */
    
    public function getWeightRangeFormattedAttribute(): string
    {
        return number_format($this->base_weight_min,2).'–'.number_format($this->base_weight_max,2).' kg';
    }

    /** Accessor format probabilitas */
    public function getCatchProbabilityFormattedAttribute(): string
    {
        return number_format($this->catch_probability,2).'%';
    }
}