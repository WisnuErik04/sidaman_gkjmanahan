<?php

namespace App\Imports;

use App\Models\Blok;
use App\Models\JarakRumah;
use App\Models\Wilayah;
use App\Models\Keluarga;
use App\Models\KeluargaDummy;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KeluargaImport implements ToCollection, WithHeadingRow
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
            if (auth()->user()->role === 'majelis') {
                $blok = Blok::where('id', $data['blok'])
                    ->where('id', auth()->user()->blok_id)
                    ->first(); // hanya ambil blok milik majelis
            } else {
                $blok = Blok::where('id', $data['blok'])->first();
            }

            $blok = Blok::where('id', $data['blok'])->first();
            $jarak_rumah = JarakRumah::where('id', $data['jarak_rumah_id'])->first();
            // dd($blok->id);
            $provinsi = Wilayah::where('name', 'like', '%'.$data['alamat_provinsi'].'%')->whereRaw('LENGTH(kode) = 2')->first();
            $kabKota  = Wilayah::where('name', 'like', '%'.$data['alamat_kab_kota'].'%')->whereRaw('CHAR_LENGTH(kode) = 5')->where('kode', 'like', optional($provinsi)->kode . '.%')->first();
            $kecamatan = Wilayah::where('name', 'like', '%'.$data['alamat_kecamatan'].'%')->whereRaw('CHAR_LENGTH(kode) = 8')->where('kode', 'like', optional($kabKota)->kode . '.%')->first();
            $desa = Wilayah::where('name', 'like', '%'.$data['alamat_desa_kelurahan'].'%')->whereRaw('CHAR_LENGTH(kode) = 13')->where('kode', 'like', optional($kecamatan)->kode . '.%')->first();

            if (! $blok || ! $jarak_rumah || ! $provinsi || ! $kabKota || ! $kecamatan || ! $desa) {
                $this->errors[] = [
                    'baris' => $rowNumber,
                    'nama' => $data['name'],
                    'Blok' => $blok ? 'OK' : 'Tidak ditemukan',
                    'Provinsi' => $provinsi ? 'OK' : 'Tidak ditemukan',
                    'Kab/ kota' => $kabKota ? 'OK' : 'Tidak ditemukan',
                    'Kecamatan' => $kecamatan ? 'OK' : 'Tidak ditemukan',
                    'Desa' => $desa ? 'OK' : 'Tidak ditemukan',
                    'Jarak' => $jarak_rumah ? 'OK' : 'Tidak ditemukan',
                ];
                continue;
            }
            $rowNumber++;
            // Cek apakah data keluarga sudah ada
            $existingKeluarga = Keluarga::where('name', 'like', '%' . $data['name'] . '%')
                ->where('blok_id', $blok->id)
                ->first();

            $numeric = preg_replace('/\D/', '', $data['alamat_rt']);
            $realNumber = substr(ltrim($numeric, '0'), 0);
            $alamat_rt =  str_pad(substr($realNumber, 0, 3), 3, '0', STR_PAD_LEFT);
            $numeric = preg_replace('/\D/', '', $data['alamat_rw']);
            $realNumber = substr(ltrim($numeric, '0'), 0);
            $alamat_rw =  str_pad(substr($realNumber, 0, 3), 3, '0', STR_PAD_LEFT);
            // Masukkan ke dummy, dengan keluarga_id jika ditemukan
            KeluargaDummy::create([
                'name' => $data['name'],
                'blok_id' => $blok->id,
                'alamat_detail' => $data['alamat_detail'],
                'alamat_rt' => $alamat_rt,
                'alamat_rw' => $alamat_rw,
                'alamat_provinsi' => $provinsi->kode,
                'alamat_kab_kota' => $kabKota->kode,
                'alamat_kecamatan' => $kecamatan->kode,
                'alamat_desa_kelurahan' => $desa->kode,
                'jarak_rumah_id' => $jarak_rumah->id,
                // Tambahkan kolom lainnya
                'keluarga_id' => $existingKeluarga?->id,
                'user_id_input' => auth()->user()->id,
            ]);
        }
        // Simpan ke session, bisa juga disimpan di file sementara
        // session(['import_keluarga_errors' => $this->errors]);
    }

    protected $headerMap = [
        // 'Blok/ Pepanthan' => 'blok',
        // 'Nama Kepala Keluarga' => 'name',
        // 'Alamat Lengkap' => 'alamat_detail',
        // 'RT' => 'alamat_rt',
        // 'RW' => 'alamat_rw',
        // 'Desa/ Kelurahan' => 'alamat_desa_kelurahan',
        // 'Kecamatan' => 'alamat_kecamatan',
        // 'Kabupaten/ Kota' => 'alamat_kab_kota',
        // 'Provinsi' => 'alamat_provinsi',
        // 'Jarak Dari Rumah Ke Tempat Ibadah' => 'jarak_rumah_id',

        "blok_pepanthan_kode" => 'blok',
        "nama_kepala_keluarga" => 'name',
        "alamat_lengkap" => 'alamat_detail',
        "rt" => 'alamat_rt',
        "rw" => 'alamat_rw',
        "desa_kelurahan" => 'alamat_desa_kelurahan',
        "kecamatan" => 'alamat_kecamatan',
        "kabupaten_kota" => 'alamat_kab_kota',
        "provinsi" => 'alamat_provinsi',
        "jarak_dari_rumah_ke_tempat_ibadah_kode" => 'jarak_rumah_id'
    ];
}
