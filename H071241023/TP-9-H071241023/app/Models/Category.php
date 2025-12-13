<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 
        'description'
    ];

    public function products() {
        return $this->hasMany(Product::class); //1 kategori bisa dimiliki oleh banyak produk
    }
}
