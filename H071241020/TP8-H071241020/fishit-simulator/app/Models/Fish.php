<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    protected $table = 'fishes'; // Pastikan sesuai dengan nama tabel
    protected $fillable = ['name', 'rarity', 'base_weight_min', 'base_weight_max', 'sell_price_per_kg', 'catch_probability', 'description', 'created_at', 'updated_at'];
}
