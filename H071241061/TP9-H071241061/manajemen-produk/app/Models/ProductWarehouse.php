<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWarehouse extends Model
{
    use HasFactory;

    protected $table = 'product_warehouse';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity'
    ];

    //Relasi Many-to-One: Stok ini dimiliki oleh satu Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi Many-to-One: Stok ini ada di satu Warehouse
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}