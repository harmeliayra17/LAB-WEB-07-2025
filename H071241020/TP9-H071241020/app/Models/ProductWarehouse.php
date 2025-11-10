<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductWarehouse extends Pivot
{
    protected $table = 'product_warehouse';
    protected $fillable = ['product_id', 'warehouse_id', 'quantity'];
    public $timestamps = true;

    // Definisikan relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Definisikan relasi ke Warehouse
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
