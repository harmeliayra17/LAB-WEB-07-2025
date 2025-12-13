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

    public function getFormattedPriceAttribute()
    {
        return number_format($this->sell_price_per_kg) . ' Coins';
    }
    public function getFormattedWeightAttribute()
    {
        return number_format($this->base_weight_min, 2) . ' - ' . 
               number_format($this->base_weight_max, 2) . ' kg';
    } 
    public function getFormattedProbabilityAttribute()
    {
        return number_format($this->catch_probability, 2) . '%';
    }
    public function getAverageWeightAttribute()
    {
        $average = ($this->base_weight_min + $this->base_weight_max) / 2;
        return number_format($average, 2 , '.') . ' kg';
    }
    public function getRarityBadgeClassAttribute()
    {
        return 'badge-' . strtolower($this->rarity);
    }
        public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d M Y, H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d M Y, H:i');
    }


    public function scopeRarity($query, $rarity)
    {
        return $query->where('rarity', $rarity);
    }
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function scopeSortByName($query, $direction = 'asc')
    {
        return $query->orderBy('name', $direction);
    }
    public function scopeSortByPrice($query, $direction = 'asc')
    {
        return $query->orderBy('sell_price_per_kg', $direction);
    }
    public function scopeSortByProbability($query, $direction = 'asc')
    {
        return $query->orderBy('catch_probability', $direction);
    }
}