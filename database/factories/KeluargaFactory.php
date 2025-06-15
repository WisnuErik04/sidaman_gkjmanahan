<?php

namespace Database\Factories;

use App\Models\Blok;
use App\Models\Wilayah;
use App\Models\Keluarga;
use App\Models\JarakRumah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keluarga>
 */
class KeluargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Keluarga::class;
    
    public function definition(): array
    {
        $provinsi = Wilayah::whereRaw('CHAR_LENGTH(kode) = 2')->inRandomOrder()->first();
        $kabKota = Wilayah::where('kode', 'LIKE', substr($provinsi->kode, 0, 5) . '%')
                          ->whereRaw('CHAR_LENGTH(kode) = 5')->inRandomOrder()->first();
        $kecamatan = Wilayah::where('kode', 'LIKE', substr($kabKota->kode, 0, 8) . '%')
                            ->whereRaw('CHAR_LENGTH(kode) = 8')->inRandomOrder()->first();
        $desa = Wilayah::where('kode', 'LIKE', substr($kecamatan->kode, 0, 10) . '%')
                            ->inRandomOrder()->first();

        return [
            'blok_id' => Blok::inRandomOrder()->value('id'),
            'name' => $this->faker->lastName . ' Family',
            'alamat_detail' => $this->faker->streetAddress,
            'alamat_rt' => str_pad($this->faker->numberBetween(1, 99), 3, '0', STR_PAD_LEFT),
            'alamat_rw' => str_pad($this->faker->numberBetween(1, 99), 3, '0', STR_PAD_LEFT),
            'alamat_desa_kelurahan' => $desa->kode ?? null,
            'alamat_kecamatan' => $kecamatan->kode ?? null,
            'alamat_kab_kota' => $kabKota->kode ?? null,
            'alamat_provinsi' => $provinsi->kode ?? null,
            'jarak_rumah_id' => JarakRumah::inRandomOrder()->value('id'),
        ];
    }
}
