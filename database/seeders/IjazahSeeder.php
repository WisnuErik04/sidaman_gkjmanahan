<?php

namespace Database\Seeders;

use App\Models\Ijazah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IjazahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["id" => 0, "name" => "Tidak punya"],
            ["id" => 1, "name" => "SD"],
            ["id" => 2, "name" => "SLTP"],
            ["id" => 3, "name" => "SLTA"],
            ["id" => 4, "name" => "SMK"],
            ["id" => 5, "name" => "DI/DII"],
            ["id" => 6, "name" => "DIII"],
            ["id" => 7, "name" => "DIV/S1"],
            ["id" => 8, "name" => "S2"],
            ["id" => 9, "name" => "S3"],
        ];

        foreach ($datas as $data) {
            Ijazah::firstOrCreate($data);
        }
    }
}
