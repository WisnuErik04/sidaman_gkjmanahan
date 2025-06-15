<?php

namespace Database\Seeders;

use App\Models\TempatBabtis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TempatBaptisSeeder extends Seeder
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
            TempatBabtis::firstOrCreate($data);
        }
    }
}
