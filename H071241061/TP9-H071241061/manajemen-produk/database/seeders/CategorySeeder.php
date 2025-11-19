<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Produk elektronik seperti laptop, smartphone, dan aksesori'
            ],
            [
                'name' => 'Pakaian',
                'description' => 'Berbagai jenis pakaian pria dan wanita'
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Produk makanan dan minuman kemasan'
            ],
            [
                'name' => 'Peralatan Rumah Tangga',
                'description' => 'Perlengkapan dan peralatan untuk kebutuhan rumah tangga'
            ],
            [
                'name' => 'Buku & Alat Tulis',
                'description' => 'Buku, alat tulis, dan perlengkapan kantor'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}