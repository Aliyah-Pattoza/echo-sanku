<?php

namespace Database\Seeders;

use App\Models\WasteType;
use Illuminate\Database\Seeder;

class WasteTypeSeeder extends Seeder
{
    public function run(): void
    {
        $wasteTypes = [
            [
                'name' => 'Botol Plastik Besar',
                'unit' => '4 pcs',
                'point_per_unit' => 1000,
                'description' => 'Botol plastik ukuran 1.5L ke atas',
                'is_active' => true,
            ],
            [
                'name' => 'Botol Plastik Sedang',
                'unit' => '8 pcs',
                'point_per_unit' => 1000,
                'description' => 'Botol plastik ukuran di bawah 1.5L',
                'is_active' => true,
            ],
            [
                'name' => 'Botol Plastik Kecil',
                'unit' => '1 kg',
                'point_per_unit' => 1000,
                'description' => 'Botol plastik ukuran sekitar 600mL',
                'is_active' => true,
            ],
            [
                'name' => 'Kardus',
                'unit' => '1 kg',
                'point_per_unit' => 1000,
                'description' => 'Kardus bekas dalam kondisi baik',
                'is_active' => true,
            ],
            [
                'name' => 'Kertas',
                'unit' => '1 kg',
                'point_per_unit' => 1000,
                'description' => 'Kertas bekas seperti buku, koran, majalah',
                'is_active' => true,
            ],
        ];

        foreach ($wasteTypes as $type) {
            WasteType::create($type);
        }
    }
}