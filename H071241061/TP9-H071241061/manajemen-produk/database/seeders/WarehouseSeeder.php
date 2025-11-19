<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Gudang Makassar',
                'location' => 'Jl. Perintis Kemerdekaan, Makassar, Sulawesi Selatan'
            ],
            [
                'name' => 'Gudang Gowa',
                'location' => 'Jl. Sultan Hasanuddin, Sungguminasa, Gowa'
            ],
            [
                'name' => 'Gudang Maros',
                'location' => 'Jl. Trans Sulawesi, Maros, Sulawesi Selatan'
            ],
            [
                'name' => 'Gudang Pare-Pare',
                'location' => 'Jl. Bau Massepe, Pare-Pare, Sulawesi Selatan'
            ],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}