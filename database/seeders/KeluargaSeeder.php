<?php

namespace Database\Seeders;

use App\Models\Keluarga;
use App\Models\KeluargaAnggota;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Keluarga::factory()->count(500)->create();
        Keluarga::factory()
            ->count(500)
            ->create()
            ->each(function ($keluarga) {
                KeluargaAnggota::factory()->count(rand(3, 5))->create([
                    'keluarga_id' => $keluarga->id,
                ]);
            });
    }
}
