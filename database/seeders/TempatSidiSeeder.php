<?php

namespace Database\Seeders;

use App\Models\TempatSidi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TempatSidiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => 'Ya, di GKJ Manahan'],
            ["name" => 'Ya, di GKJ lainnya'],
            ["name" => 'Ya, bukan di GKJ'],
            ["name" => 'Belum baptis'],
        ];
    
        foreach ($datas as $data) {
            TempatSidi::firstOrCreate($data);
        }
    }
}
