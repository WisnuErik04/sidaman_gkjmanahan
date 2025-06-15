<?php

namespace App\Imports;

use App\Models\Blok;
use App\Models\Hobi;
use App\Models\Ijazah;
use App\Models\GolDarah;
use App\Models\Keluarga;
use App\Models\Penyakit;
use App\Models\Pekerjaan;
use App\Models\Pendapatan;
use App\Models\Perkawinan;
use App\Models\TempatSidi;
use App\Models\TempatBabtis;
use App\Models\HubunganKeluarga;
use App\Models\KeluargaAnggota;
use App\Models\KeluargaAnggotaDummy;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnggotaImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */

    public $errors = [];
    public function collection(Collection $rows)
    {
        $rowNumber = 2; // karena baris 1 = heading
        $this->errors = [];

        foreach ($rows as $row) {
            foreach ($this->headerMap as $excelHeader => $internalKey) {
                $data[$internalKey] = $row[$excelHeader] ?? null;
            }
            // dd($row);

            // Ambil blok (asumsi yang diinput nama blok)
            $hubunganKeluargas = HubunganKeluarga::where('id', $data['hubungan_keluarga_id'])->first();
            $perkawinans = Perkawinan::where('id', $data['perkawinan_id'])->first();
            $golDarahs = GolDarah::where('id', $data['gol_darah_id'])->first();
            $ijazahs = Ijazah::where('id', $data['ijazah_id'])->first();
            $pekerjaans = Pekerjaan::where('id', $data['pekerjaan_id'])->first();
            $pendapatans = Pendapatan::where('id', $data['pendapatan_id'])->first();
            $tempatBabtises = TempatBabtis::where('id', $data['tempat_babtis_id'])->first();
            $tempatSidis = TempatSidi::where('id', $data['tempat_sidi_id'])->first();
            $hobis = Hobi::where('id', $data['hobi_id'])->first();
            $penyakits = Penyakit::where('id', $data['penyakit_id'])->first();
            
            // Cek apakah data keluarga sudah ada
            if (auth()->user()->role === 'majelis') {
                $blok = Blok::where('id', $data['blok'])
                    ->where('id', auth()->user()->blok_id)
                    ->first(); // hanya ambil blok milik majelis
            } else {
                $blok = Blok::where('id', $data['blok'])->first();
            }
            $existingKeluarga = Keluarga::where('name', 'like', '%' . $data['kepala_keluarga'] . '%')
                ->where('blok_id', $blok?->id)
                ->first();

            if (! $existingKeluarga ||
                ! in_array($data['jns_kelamin'], ['L', 'P']) ||
                ! in_array($data['memiliki_bpjs_asuransi'], ['Y', 'N']) ||
                ! in_array($data['domisili_alamat'], ['Y', 'N']) ||
                ! $hubunganKeluargas ||
                ! $perkawinans ||
                ! $golDarahs ||
                ! $ijazahs ||
                ! $pekerjaans ||
                ! $pendapatans ||
                ! $tempatBabtises ||
                ! $tempatSidis ||
                ! $hobis ||
                ! $penyakits) {
                $this->errors[] = [
                    'baris' => $rowNumber,
                    'nama' => $data['name'],
                    'jns_kelamin' => in_array($data['jns_kelamin'], ['L', 'P']) ? 'OK' : 'Tidak valid (harus L atau P)',
                    'memiliki_bpjs_asuransi' => in_array($data['memiliki_bpjs_asuransi'], ['Y', 'N']) ? 'OK' : 'Tidak valid (harus Y atau N)',
                    'domisili_alamat' => in_array($data['domisili_alamat'], ['Y', 'N']) ? 'OK' : 'Tidak valid (harus Y atau N)',
                    'Kepla keluarga dan Blok' => $existingKeluarga ? 'OK' : 'Kepala keluarga dan Blok tidak sesuai',
                    'Hubungan keluarga' => $hubunganKeluargas ? 'OK' : 'Tidak ditemukan',
                    'Status perkawinan' => $perkawinans ? 'OK' : 'Tidak ditemukan',
                    'Golongan darah' => $golDarahs ? 'OK' : 'Tidak ditemukan',
                    'Ijasah terakhir' => $ijazahs ? 'OK' : 'Tidak ditemukan',
                    'Kegiatan/ Pekerjaan' => $pekerjaans ? 'OK' : 'Tidak ditemukan',
                    'Pendapatan per bulan' => $pendapatans ? 'OK' : 'Tidak ditemukan',
                    'Tempat baptis anak' => $tempatBabtises ? 'OK' : 'Tidak ditemukan',
                    'Tempat baptis dewasa/ Sidi' => $tempatSidis ? 'OK' : 'Tidak ditemukan',
                    'Talenta/ Hobi' => $hobis ? 'OK' : 'Tidak ditemukan',
                    'Apakah mempunyai penyakit kronis' => $penyakits ? 'OK' : 'Tidak ditemukan',
                ];
                continue;
            }
            $rowNumber++;
            // Cek apakah data keluarga sudah ada
            $existingKeluargaAnggota = KeluargaAnggota::where('name', 'like', '%' . $data['name'] . '%')
                ->where('keluarga_id', $existingKeluarga?->id)
                ->first();

            // $query = KeluargaAnggota::where('name', 'like', '%' . $data['name'] . '%')
            //     ->where('keluarga_id', $existingKeluarga?->id);
            // dd($query->toSql(), $query->getBindings());
            // Masukkan ke dummy, dengan keluarga_id jika ditemukan
            KeluargaAnggotaDummy::create([
                'keluarga_id' => $existingKeluarga?->id,
                'name' => $data['name'],
                'jns_kelamin' => $data['jns_kelamin'],
                'nomor_induk_gereja' => $data['nomor_induk_gereja'],
                'hubungan_keluarga_id' => $hubunganKeluargas->id,
                'perkawinan_id' => $perkawinans->id,
                'tgl_lahir' => $data['tgl_lahir'],
                'gol_darah_id' => $golDarahs->id,
                'ijazah_id' => $ijazahs->id,
                'pekerjaan_id' => $pekerjaans->id,
                'pendapatan_id' => $pendapatans->id,
                'tempat_babtis_id' => $tempatBabtises->id,
                'tgl_babtis' => $data['tgl_babtis'],
                'tempat_sidi_id' => $tempatSidis->id,
                'tgl_sidi' => $data['tgl_sidi'],
                'hobi_id' => $hobis->id,
                'aktifitas_pelayanan' => $data['aktifitas_pelayanan'],
                'memiliki_bpjs_asuransi' => ($data['memiliki_bpjs_asuransi'] == 'Y') ? '1' : '2',
                'penyakit_id' => $penyakits->id,
                'domisili_alamat' => ($data['domisili_alamat'] == 'Y') ? '1' : '2',
                'nomor_wa' => $data['nomor_wa'],
                // Tambahkan kolom lainnya
                'keluarga_anggota_id' => $existingKeluargaAnggota?->id,
                'user_id_input' => auth()->user()->id,
            ]);
        }
        // Simpan ke session, bisa juga disimpan di file sementara
        // session(['import_keluarga_errors' => $this->errors]);
    }

    protected $headerMap = [
        "kepala_keluarga" => "kepala_keluarga",
        "blok_kode" => "blok",
        "nama_anggota_keluarga" => "name",
        "jenis_kelamin_lp" => "jns_kelamin", 
        "nomor_induk_gereja" => "nomor_induk_gereja", 
        "hubungan_keluarga_kode" => "hubungan_keluarga_id", 
        "status_perkawinan_kode" => "perkawinan_id", 
        "tanggal_lahir" => "tgl_lahir", 
        "golongan_darah_kode" => "gol_darah_id", 
        "ijasah_terakhir_kode" => "ijazah_id",
        "kegiatan_pekerjaan_kode" => "pekerjaan_id", 
        "pendapatan_per_bulan_kode" => "pendapatan_id", 
        "tempat_baptis_anak_kode" => "tempat_babtis_id", 
        "tanggal_baptis_anak" => "tgl_babtis", 
        "tempat_baptis_dewasa_sidi_kode" => "tempat_sidi_id", 
        "tanggal_baptis_dewasa_sidi" => "tgl_sidi", 
        "talenta_hobi_kode" => "hobi_id", 
        "aktivitas_pelayanan_yg_aktif_diikuti" => "aktifitas_pelayanan", 
        "memiliki_bpjs_atau_asuransi_lainnya_yn" => "memiliki_bpjs_asuransi", 
        "apakah_mempunyai_penyakit_kronis_kode" => "penyakit_id", 
        "domisili_di_alamat_ini_yn" => "domisili_alamat", 
        "nomor_wa" => "nomor_wa", 
    ];
}
