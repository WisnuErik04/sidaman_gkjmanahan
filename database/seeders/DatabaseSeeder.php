<?php

namespace Database\Seeders;

use App\Models\Ijazah;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            BlokSeeder::class,
            GolDarahSeeder::class,
            HobiSeeder::class,
            HubunganKeluargaSeeder::class,
            IjazahSeeder::class,
            PekerjaanSeeder::class,
            PendapatanSeeder::class,
            PenyakitSeeder::class,
            PerkawinanSeeder::class,
            TempatBaptisSeeder::class,
            TempatSidiSeeder::class,
        ]);
    }
}
