<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductDetail;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $elektronik = Category::create([
            'name' => 'Elektronik',
            'description' => 'Semua produk elektronik seperti laptop, HP, dan aksesoris.'
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'description' => 'Pakaian, sepatu, dan aksesoris fashion.'
        ]);

        $gudangMakassar = Warehouse::create([
            'name' => 'Gudang Makassar',
            'location' => 'Jl. A.P. Pettarani, Makassar'
        ]);

        $gudangGowa = Warehouse::create([
            'name' => 'Gudang Gowa',
            'location' => 'Jl. Poros Malino, Gowa'
        ]);

        $laptop = Product::create([
            'name' => 'Laptop ASUS Vivobook 15',
            'price' => 7500000.00,
            'category_id' => $elektronik->id
        ]);

        ProductDetail::create([
            'product_id' => $laptop->id,
            'description' => 'Laptop tipis dengan prosesor Intel Core i5, RAM 8GB, SSD 512GB.',
            'weight' => 1.80,
            'size' => '15.6 inch'
        ]);

        $sepatu = Product::create([
            'name' => 'Sepatu Sneakers Nike Air',
            'price' => 1200000.00,
            'category_id' => $fashion->id
        ]);

        ProductDetail::create([
            'product_id' => $sepatu->id,
            'description' => 'Sepatu sneakers original dengan bantalan udara.',
            'weight' => 0.75,
            'size' => '42'
        ]);

        $laptop->warehouses()->attach($gudangMakassar->id, ['quantity' => 10]);
        $laptop->warehouses()->attach($gudangGowa->id, ['quantity' => 5]);

        $sepatu->warehouses()->attach($gudangMakassar->id, ['quantity' => 20]);
        $sepatu->warehouses()->attach($gudangGowa->id, ['quantity' => 8]);
    }
}