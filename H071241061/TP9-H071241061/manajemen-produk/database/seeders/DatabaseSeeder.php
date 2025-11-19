<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan penting: parent tables dulu, baru child tables
        $this->call([
            CategorySeeder::class,
            WarehouseSeeder::class,
            ProductSeeder::class, // Harus terakhir karena bergantung pada Category & Warehouse
        ]);
    }
}