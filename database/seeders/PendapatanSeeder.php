<?php

namespace Database\Seeders;

use App\Models\Pendapatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendapatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => '< 1 juta'],
            ["name" => '1 - 2 Juta'],
            ["name" => '2 - 3 Juta'],
            ["name" => '> 3 Juta'],
        ];
    
        foreach ($datas as $data) {
            Pendapatan::firstOrCreate($data);
        }
    }
}
