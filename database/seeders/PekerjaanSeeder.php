<?php

namespace Database\Seeders;

use App\Models\Pekerjaan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $datas = [
            ["name" => 'Tdk sekolah/ Bekerja'],
            ["name" => 'Sekolah'],
            ["name" => 'mengurus RT'],
            ["name" => 'Pensiun'],
            ["name" => 'PNS'],
            ["name" => 'TNI/POLRI'],
            ["name" => 'BUMN/BUMD'],
            ["name" => 'Peg.Swasta'],
            ["name" => 'Usaha sendiri'],
            ["name" => 'Usaha dg karya tetap'],
            ["name" => 'Driver online'],
            ["name" => 'Pekerja sosial'],
            ["name" => 'Lainnya'],
        ];
    
        foreach ($datas as $data) {
            Pekerjaan::firstOrCreate($data);
        }
    }
}
