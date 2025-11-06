<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'sell_price_per_kg' => 'integer',
        'catch_probability' => 'decimal:2',
    ];

    public function scopeOfRarity($query, $rarity)
    {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->sell_price_per_kg) . ' Coins/kg',
        );
    }

    protected function formattedWeightRange(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->base_weight_min . 'kg - ' . $this->base_weight_max . 'kg',
        );
    }

    protected function formattedProbability(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->catch_probability . '%',
        );
    }
}