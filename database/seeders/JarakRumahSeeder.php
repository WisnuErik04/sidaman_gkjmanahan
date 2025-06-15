<?php

namespace Database\Seeders;

use App\Models\JarakRumah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JarakRumahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => '< 1 Km'],
            ["name" => '1 - 5 Km'],
            ["name" => '5 - 10 Km'],
            ["name" => '> 10 Km'],
        ];

        foreach ($datas as $data) {
            JarakRumah::firstOrCreate($data);
        }
    }
}
