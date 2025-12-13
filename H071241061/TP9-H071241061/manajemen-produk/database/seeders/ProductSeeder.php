<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $elektronik = Category::where('name', 'Elektronik')->first();
        $pakaian = Category::where('name', 'Pakaian')->first();
        $makanan = Category::where('name', 'Makanan & Minuman')->first();
        
        $gudangMakassar = Warehouse::where('name', 'Gudang Makassar')->first();
        $gudangGowa = Warehouse::where('name', 'Gudang Gowa')->first();
        $gudangMaros = Warehouse::where('name', 'Gudang Maros')->first();

        // Produk Elektronik
        DB::transaction(function () use ($elektronik, $gudangMakassar, $gudangGowa) {
            $laptop = Product::create([
                'name' => 'Laptop ASUS ROG',
                'price' => 15000000,
                'category_id' => $elektronik->id,
            ]);

            $laptop->detail()->create([
                'description' => 'Laptop gaming dengan spesifikasi tinggi, RAM 16GB, SSD 512GB',
                'weight' => 2.5,
                'size' => '15.6 inch',
            ]);

            // Tambah stok di gudang
            $laptop->warehouses()->attach([
                $gudangMakassar->id => ['quantity' => 15],
                $gudangGowa->id => ['quantity' => 10],
            ]);
        });

        DB::transaction(function () use ($elektronik, $gudangMakassar, $gudangMaros) {
            $smartphone = Product::create([
                'name' => 'Samsung Galaxy S23',
                'price' => 12000000,
                'category_id' => $elektronik->id,
            ]);

            $smartphone->detail()->create([
                'description' => 'Smartphone flagship dengan kamera 50MP, RAM 8GB',
                'weight' => 0.2,
                'size' => '6.1 inch',
            ]);

            $smartphone->warehouses()->attach([
                $gudangMakassar->id => ['quantity' => 25],
                $gudangMaros->id => ['quantity' => 20],
            ]);
        });

        // Produk Pakaian
        DB::transaction(function () use ($pakaian, $gudangGowa, $gudangMaros) {
            $kaos = Product::create([
                'name' => 'Kaos Polos Premium',
                'price' => 85000,
                'category_id' => $pakaian->id,
            ]);

            $kaos->detail()->create([
                'description' => 'Kaos cotton combed 30s, nyaman dan adem',
                'weight' => 0.15,
                'size' => 'L, XL, XXL',
            ]);

            $kaos->warehouses()->attach([
                $gudangGowa->id => ['quantity' => 100],
                $gudangMaros->id => ['quantity' => 80],
            ]);
        });

        // Produk Makanan
        DB::transaction(function () use ($makanan, $gudangMakassar, $gudangGowa, $gudangMaros) {
            $snack = Product::create([
                'name' => 'Kopi Toraja Premium',
                'price' => 75000,
                'category_id' => $makanan->id,
            ]);

            $snack->detail()->create([
                'description' => 'Kopi arabika asli Toraja, kemasan 250 gram',
                'weight' => 0.25,
                'size' => '250gr',
            ]);

            $snack->warehouses()->attach([
                $gudangMakassar->id => ['quantity' => 50],
                $gudangGowa->id => ['quantity' => 40],
                $gudangMaros->id => ['quantity' => 30],
            ]);
        });

        DB::transaction(function () use ($makanan, $gudangMakassar) {
            $snack2 = Product::create([
                'name' => 'Keripik Pisang Epe',
                'price' => 35000,
                'category_id' => $makanan->id,
            ]);

            $snack2->detail()->create([
                'description' => 'Keripik pisang khas Makassar dengan berbagai rasa',
                'weight' => 0.2,
                'size' => '200gr',
            ]);

            $snack2->warehouses()->attach([
                $gudangMakassar->id => ['quantity' => 75],
            ]);
        });
    }
}