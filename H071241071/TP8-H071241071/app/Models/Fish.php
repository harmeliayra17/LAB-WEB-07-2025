<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fish extends Model
{
    use HasFactory;

    protected $table = 'fishes';
    
    protected $fillable = [
        'name', 'rarity', 'base_weight_min', 'base_weight_max',
        'sell_price_per_kg', 'catch_probability', 'description'
    ];

    public function getFormattedWeightAttribute()
    {
        return "{$this->base_weight_min} kg - {$this->base_weight_max} kg";
    }

    public function getFormattedPriceAttribute()
    {
        return "{$this->sell_price_per_kg} Coins/kg";
    }

    public function getFormattedProbabilityAttribute()
    {
        return "{$this->catch_probability}%";
    }

    public function scopeRarity($query, $rarity)
    {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
    }
}
