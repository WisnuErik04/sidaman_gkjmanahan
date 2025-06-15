<?php

namespace Database\Seeders;

use App\Models\Penyakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["id" => 0, "name" => 'Tidak ada'],
            ["id" => 1, "name" => 'Jantung'],
            ["id" => 2, "name" => 'Kanker'],
            ["id" => 3, "name" => 'Gagal ginjal'],
            ["id" => 4, "name" => 'Asma'],
            ["id" => 5, "name" => 'Diabetes'],
            ["id" => 6, "name" => 'hipertensi'],
            ["id" => 7, "name" => 'Stroke'],
            ["id" => 8, "name" => 'Lainnya'],
        ];
       
        foreach ($datas as $data) {
            Penyakit::firstOrCreate($data);
        }
    }
}
