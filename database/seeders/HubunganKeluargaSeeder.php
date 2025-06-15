<?php

namespace Database\Seeders;

use App\Models\HubunganKeluarga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HubunganKeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => 'Kepala Keluarga'],
            ["name" => 'Istri/Suami'],
            ["name" => 'Anak'],
            ["name" => 'Menantu'],
            ["name" => 'Cucu'],
            ["name" => 'Orangtua'],
            ["name" => 'Mertua'],
            ["name" => 'Saudara Kandung'],
            ["name" => 'Saudara'],
            ["name" => 'Lainnya'],
        ];
    
        foreach ($datas as $data) {
            HubunganKeluarga::firstOrCreate($data);
        }
    }
}
