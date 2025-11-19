<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'category_id'];

    // Relasi Many-to-One: Product dimiliki oleh satu Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi One-to-One: Product memiliki satu ProductDetail
    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    // Relasi Many-to-Many: Product ada di banyak Warehouse
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getTotalStockAttribute()
    {
        return $this->warehouses()->sum('quantity');
    }
}
