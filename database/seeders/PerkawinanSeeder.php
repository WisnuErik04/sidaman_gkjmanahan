<?php

namespace Database\Seeders;

use App\Models\Perkawinan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerkawinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => 'Belum Kawin'],
            ["name" => 'Kawin'],
            ["name" => 'Cerai hidup'],
            ["name" => 'Cerai mati'],
        ];
    
        foreach ($datas as $data) {
            Perkawinan::firstOrCreate($data);
        }
    }
}
