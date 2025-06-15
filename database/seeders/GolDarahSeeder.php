<?php

namespace Database\Seeders;

use App\Models\GolDarah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GolDarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => 'O'],
            ["name" => 'A'],
            ["name" => 'B'],
            ["name" => 'AB'],
        ];
    
        foreach ($datas as $data) {
            GolDarah::firstOrCreate($data);
        }
    }
}
