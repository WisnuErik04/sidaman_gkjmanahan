<?php

namespace Database\Seeders;

use App\Models\Hobi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HobiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => 'Menyanyi'],
            ["name" => 'Bermusik'],
            ["name" => 'Menari'],
            ["name" => 'Melukis'],
            ["name" => 'Teater'],
            ["name" => 'Fotografi'],
            ["name" => 'Pertunjukan'],
            ["name" => 'Lainnya'],
        ];

        foreach ($datas as $data) {
            Hobi::firstOrCreate($data);
        }
    }
}
