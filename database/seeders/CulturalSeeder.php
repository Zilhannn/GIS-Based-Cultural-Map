<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cultural;

class CulturalSeeder extends Seeder
{
    public function run(): void
    {
        Cultural::create([
            'name' => 'Candi Cangkuang',
            'category' => 'Bangunan Bersejarah',
            'description' => 'Candi Hindu peninggalan abad ke-8 yang terletak di Garut.',
            'location' => 'Desa Cangkuang, Garut',
            'image' => 'candi-cangkuang.jpg'
        ]);

        Cultural::create([
            'name' => 'Dodol Garut',
            'category' => 'Kuliner',
            'description' => 'Makanan khas Garut yang terbuat dari ketan dan gula kelapa.',
            'location' => 'Garut Kota',
            'image' => 'dodol-garut.jpg'
        ]);
    }
}
