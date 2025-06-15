<?php

namespace Database\Seeders;

use App\Models\Blok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ["name" => 'Blok I'],
            ["name" => 'Blok II'],
            ["name" => 'Blok III'],
            ["name" => 'Blok IV'],
            ["name" => 'Blok V'],
            ["name" => 'Blok VI'],
            ["name" => 'Blok VII'],
            ["name" => 'Blok VIII'],
            ["name" => 'Blok IX'],
            ["name" => 'Blok X'],
            ["name" => 'Blok XI'],
            ["name" => 'Blok XII'],
            ["name" => 'Blok XIII'],
            ["name" => 'Blok XIV'],
            ["name" => 'Blok XV'],
            ["name" => 'Blulukan'],
        ];
        
        foreach ($datas as $data) {
            Blok::firstOrCreate($data);
        }
    }
}
