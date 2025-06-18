<?php

namespace Database\Factories;

use App\Models\Hobi;
use App\Models\User;
use App\Models\Ijazah;
use App\Models\GolDarah;
use App\Models\Keluarga;
use App\Models\Penyakit;
use App\Models\Pekerjaan;
use App\Models\Pendapatan;
use App\Models\Perkawinan;
use App\Models\TempatSidi;
use App\Models\TempatBabtis;
use App\Models\KeluargaAnggota;
use App\Models\HubunganKeluarga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KeluargaAnggota>
 */
class KeluargaAnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = KeluargaAnggota::class;
    public function definition(): array
    {
        return [
            'keluarga_id' => Keluarga::inRandomOrder()->value('id'),
            'user_id' => null, // atau User::inRandomOrder()->value('id') jika ingin dihubungkan
            'name' => $this->faker->name,
            'jns_kelamin' => $this->faker->randomElement(['L', 'P']),
            'nomor_induk_gereja' => $this->faker->unique()->numerify('NIG###'),
            'hubungan_keluarga_id' => HubunganKeluarga::inRandomOrder()->value('id'),
            'perkawinan_id' => Perkawinan::inRandomOrder()->value('id'),
            'tgl_lahir' => $this->faker->date('Y-m-d', '-5 years'),
            'gol_darah_id' => GolDarah::inRandomOrder()->value('id'),
            'ijazah_id' => Ijazah::inRandomOrder()->value('id'),
            'pekerjaan_id' => Pekerjaan::inRandomOrder()->value('id'),
            'pendapatan_id' => Pendapatan::inRandomOrder()->value('id'),

            'tempat_babtis_id' => TempatBabtis::inRandomOrder()->value('id'),
            'tgl_babtis' => $this->faker->date('Y-m-d', '-1 years'),
            'tempat_sidi_id' => TempatSidi::inRandomOrder()->value('id'),
            'tgl_sidi' => $this->faker->date('Y-m-d', '-6 months'),
            'hobi_id' => Hobi::inRandomOrder()->value('id'),
            'aktifitas_pelayanan' => $this->faker->sentence(3),
            'memiliki_bpjs_asuransi' => $this->faker->randomElement(['1', '2']),
            'penyakit_id' => Penyakit::inRandomOrder()->value('id'),
            'domisili_alamat' => $this->faker->randomElement(['1', '2']),
            'nomor_wa' => $this->faker->numerify('08##########'),
            'is_wafat' => '0',
        ];
    }
}
