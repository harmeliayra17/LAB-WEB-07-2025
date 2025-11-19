<?php

namespace Database\Seeders;

use App\Models\ProductDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Product;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $category1 = Category::create([
            'name' => 'Appetizer',
            'description' => 'Hidangan pembuka yang disajikan sebelum makanan utama. Biasanya porsi kecil untuk merangsang selera makan'
        ]);
        $category2 = Category::create([
            'name' => 'Main Course',
            'description' => 'Hidangan utama yang porsinya paling besar dan paling mengenyangkan'
        ]);
        $category3 = Category::create([
            'name' => 'Side Dish',
            'description' => 'Hidangan pendamping yang melengkapi main course'
        ]);
        $category4 = Category::create([
            'name' => 'Dessert',
            'description' => 'Hidangan penutup yang disajikan setelah main course, biasanya manis-manis'
        ]);
        $category5 = Category::create([
            'name' => 'Beverage',
            'description' => 'Semua jenis minuman, baik panas maupun dingin'
        ]);


        $warehouse1 = Warehouse::create([
            'name' => 'Warung Pecel Lele H. Slamet', 
            'location' => 'Jl. A.P Pettarani'
        ]);
        $warehouse2 = Warehouse::create([
            'name' => 'Warung Rasa Sayang-Sayange Mbak Sri', 
            'location' => 'Jl. Perintis Kemerdekaan'
        ]);


        $product1 = Product::create([
            'name' => 'Kerupuk Udang',
            'price' => 5000, 
            'category_id' => $category1 -> id
        ]);
        ProductDetail::create([
            'product_id' => $product1 -> id,
            'description' => 'Kerupuk pake sari-sari udang asli',
            'weight' => 0.10,
            'size' => 'Kecil'
        ]);

        $product2 = Product::create([
            'name' => 'Pecel Lele',
            'price' => 15000, 
            'category_id' => $category2 -> id
        ]);
        ProductDetail::create([
            'product_id' => $product2 -> id,
            'description' => 'Pecel Lele enyak maknyus',
            'weight' => 0.50,
            'size' => 'Sedang'
        ]);

        $product3 = Product::create([
            'name' => 'Tempe Goreng',
            'price' => 1000, 
            'category_id' => $category3 -> id
        ]);
        ProductDetail::create([
            'product_id' => $product3 -> id,
            'description' => 'Tempe dengan bumbu racik',
            'weight' => 0.10,
            'size' => 'Kecil'
        ]);

        $product4 = Product::create([
            'name' => 'Pisang Goreng',
            'price' => 2000, 
            'category_id' => $category4 -> id
        ]);
        ProductDetail::create([
            'product_id' => $product4 -> id,
            'description' => 'Pisang goreng goreng pisang',
            'weight' => 0.10,
            'size' => 'Sedang'
        ]);

        $product5 = Product::create([
            'name' => 'Es Teh Manis',
            'price' => 4000, 
            'category_id' => $category5 -> id
        ]);
        ProductDetail::create([
            'product_id' => $product5 -> id,
            'description' => 'Teh pakai gula dan es',
            'weight' => 0.20,
            'size' => 'Sedang'
        ]);

        $product1 -> warehouses() -> attach($warehouse1 -> id, ['quantity' => 10]);
        $product1 -> warehouses() -> attach($warehouse2 -> id, ['quantity' => 20]);
        $product2 -> warehouses() -> attach($warehouse1 -> id, ['quantity' => 100]);
        $product3 -> warehouses() -> attach($warehouse1 -> id, ['quantity' => 50]);
        $product3 -> warehouses() -> attach($warehouse2 -> id, ['quantity' => 60]);
        $product4 -> warehouses() -> attach($warehouse2 -> id, ['quantity' => 20]);
        $product5 -> warehouses() -> attach($warehouse1 -> id, ['quantity' => 70]);
        $product5 -> warehouses() -> attach($warehouse2 -> id, ['quantity' => 70]);
    }
}