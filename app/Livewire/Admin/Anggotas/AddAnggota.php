<?php

namespace App\Livewire\Admin\Anggotas;

use Flux\Flux;
use App\Models\Hobi;
use App\Models\User;
use App\Models\Ijazah;
use Livewire\Component;
use App\Models\GolDarah;
use App\Models\Keluarga;
use App\Models\Penyakit;
use App\Models\Pekerjaan;
use App\Models\Pendapatan;
use App\Models\Perkawinan;
use App\Models\TempatSidi;
use App\Models\TempatBabtis;
use App\Models\StatusAnggota;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;
use App\Models\HubunganKeluarga;
use App\Models\KeluargaAnggotaStatusRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

#[Title('Tambah Anggota Keluarga | Sidaman')]
class AddAnggota extends Component
{
    public $menuName = 'Anggota Keluarga';
    public $keluarga_id;
    public
        $user_id,
        $name,
        $jns_kelamin,
        $nomor_induk_gereja,
        $hubungan_keluarga_id,
        $perkawinan_id,
        $tgl_lahir,
        $gol_darah_id,
        $ijazah_id,
        $pekerjaan_id,
        $pendapatan_id,
        $tempat_babtis_id,
        $tgl_babtis,
        $tempat_sidi_id,
        $tgl_sidi,
        // $hobi_id,
        $aktifitas_pelayanan,
        $memiliki_bpjs_asuransi,
        // $penyakit_id,
        $domisili_alamat,
        $nomor_wa,
        // $is_wafat,
        $tgl_wafat;
    public $hobi_id = [];
    public $penyakit_id = [];
    public $status_anggota_id;
    public $tanggal_input;

    public $keluargas = [];
    public $hubunganKeluargas = [];
    public $perkawinans = [];
    public $golDarahs = [];
    public $ijazahs = [];
    public $pekerjaans = [];
    public $pendapatans = [];
    public $tempatBabtises = [];
    public $tempatSidis = [];
    public $hobis = [];
    public $penyakits = [];
    public $statuses = [];

    public $riwayatInputStatus = [];


    public function mount()
    {
        $this->keluargas = Keluarga::all();
        if (auth()->user()->role == 'majelis') {
            $this->keluargas = Keluarga::where('blok_id', auth()->user()->blok_id)->get();
        }
        $this->hubunganKeluargas = HubunganKeluarga::all();
        $this->perkawinans = Perkawinan::all();
        $this->golDarahs = GolDarah::all();
        $this->ijazahs = Ijazah::all();
        $this->pekerjaans = Pekerjaan::all();
        $this->pendapatans = Pendapatan::all();
        $this->tempatBabtises = TempatBabtis::all();
        $this->tempatSidis = TempatSidi::all();
        $this->hobis = Hobi::all();
        $this->penyakits = Penyakit::all();
        $this->statuses = StatusAnggota::all();
        $this->addRiwayat();
    }

    // Fungsi untuk menambah baris baru di repeater
    public function addRiwayat()
    {
        $this->riwayatInputStatus[] = [
            'id'      => null,
            'status' => '',
            'tanggal' => date('Y-m-d')
        ];
    }

    // Fungsi untuk menghapus baris tertentu di repeater
    public function removeRiwayat($index)
    {
        unset($this->riwayatInputStatus[$index]);
        $this->riwayatInputStatus = array_values($this->riwayatInputStatus); // Reset index array
    }

    public function saveAnggota()
    {

        $this->validate([
            'keluarga_id' => 'required',
            'user_id' => 'nullable',
            'name' => 'required|string|max:255|unique:users,email',
            'jns_kelamin' => 'required|in:L,P',
            'nomor_induk_gereja' => 'nullable|string|max:255',
            'hubungan_keluarga_id' => 'required',
            'perkawinan_id' => 'required',
            'tgl_lahir' => 'required|date',
            'gol_darah_id' => 'nullable',
            'ijazah_id' => 'required',
            'pekerjaan_id' => 'required',
            // 'pendapatan_id' => 'required',
            // 'tempat_babtis_id' => 'required',
            // 'tgl_babtis' => 'required|date',
            // 'tempat_sidi_id' => 'required',
            // 'tgl_sidi' => 'required|date',
            // 'hobi_id' => 'required',
            // 'aktifitas_pelayanan' => 'required',
            'pendapatan_id' => 'nullable',
            'tempat_babtis_id' => 'nullable',
            'tgl_babtis' => 'nullable|date',
            'tempat_sidi_id' => 'nullable',
            'tgl_sidi' => 'nullable|date',
            'hobi_id' => 'nullable|array',
            'hobi_id.*' => 'exists:hobis,id',
            'aktifitas_pelayanan' => 'nullable',
            'memiliki_bpjs_asuransi' => 'required|in:1,2',
            'penyakit_id' => 'required|array',
            'penyakit_id.*' => 'exists:penyakits,id',
            'domisili_alamat' => 'required|in:1,2',
            // 'nomor_wa' => 'string|max:12',
            'nomor_wa' => 'nullable|string|max:15',
            // 'is_wafat' => 'in:1,0|nullable',
            // 'tgl_wafat' => 'date|nullable',
            // 'status_anggota_id' => 'required|exists:status_anggotas,id',
            // 'tanggal_input' => 'required|date'
            // Validasi tambahan untuk Repeater Riwayat Status Anda
            'riwayatInputStatus' => 'nullable|array',
            'riwayatInputStatus.*.status' => 'required|exists:status_anggotas,id',
            'riwayatInputStatus.*.tanggal' => 'required|date',
        ], [
            // Custom message khusus untuk repeater riwayat status
            'riwayatInputStatus.*.status.required' => 'Status di tabel riwayat wajib diisi.',
            'riwayatInputStatus.*.tanggal.required' => 'Tanggal di tabel riwayat wajib diisi.',
        ]);
        // dd('ad');
        DB::transaction(function () {

            $user = User::create([
                'name' => $this->name,
                'email' => $this->name,
                'password' => Hash::make('12345678'),
                'role' => 'warga',
            ]);

            $keluarga_anggota = KeluargaAnggota::create([
                'keluarga_id' => $this->keluarga_id,
                'user_id' => $user->id,
                'name' => $this->name,
                'jns_kelamin' => $this->jns_kelamin,
                'nomor_induk_gereja' => $this->nomor_induk_gereja,
                'hubungan_keluarga_id' => $this->hubungan_keluarga_id,
                'perkawinan_id' => $this->perkawinan_id,
                'tgl_lahir' => $this->tgl_lahir,
                'gol_darah_id' => $this->gol_darah_id,
                'ijazah_id' => $this->ijazah_id,
                'pekerjaan_id' => $this->pekerjaan_id,
                'pendapatan_id' => $this->pendapatan_id,
                'tempat_babtis_id' => $this->tempat_babtis_id,
                'tgl_babtis' => $this->tgl_babtis,
                'tempat_sidi_id' => $this->tempat_sidi_id,
                'tgl_sidi' => $this->tgl_sidi,
                // 'hobi_id' => $this->hobi_id,
                'aktifitas_pelayanan' => $this->aktifitas_pelayanan,
                'memiliki_bpjs_asuransi' => $this->memiliki_bpjs_asuransi,
                // 'penyakit_id' => $this->penyakit_id,
                'domisili_alamat' => $this->domisili_alamat,
                'nomor_wa' => $this->nomor_wa,
                // 'is_wafat' => $this->is_wafat ?? '0',
                // 'status_anggota_id' => $this->status_anggota_id,
            ]);
            // dd($keluarga_anggota->recordHobi()->sync($this->hobi_id));
            // Create status record


            // dd($keluarga_anggota->recordPenyakit()->sync($this->penyakit_id));
            if (!empty($this->hobi_id)) {
                $keluarga_anggota->recordHobi()->sync($this->hobi_id);
            }

            if (!empty($this->penyakit_id)) {
                $keluarga_anggota->recordPenyakit()->sync($this->penyakit_id);
            }

            // 3. SEKARANG: Loop dan Simpan Data dari Repeater Riwayat Status
            // Pastikan properti array $riwayatInputStatus tidak kosong sebelum diproses
            if (!empty($this->riwayatInputStatus)) {

                // 1. Kumpulkan ID dari repeater yang bertipe data lama (bukan null)
                $keptIds = collect($this->riwayatInputStatus)
                    ->pluck('id')
                    ->filter() // Menghilangkan nilai null (data baru)
                    ->toArray();

                // 2. Hapus data di database yang tidak ada di daftar $keptIds
                KeluargaAnggotaStatusRecord::where('keluarga_anggota_id', $keluarga_anggota->id)
                    ->whereNotIn('id', $keptIds)
                    ->delete();

                // 3. Lakukan Loop untuk Update atau Create

                $is_wafat = 0;
                foreach ($this->riwayatInputStatus as $riwayat) {
                    if (isset($riwayat['id']) && !empty($riwayat['id'])) {
                        // Jika ID ada, berarti update record yang sudah ada
                        KeluargaAnggotaStatusRecord::where('id', $riwayat['id'])->update([
                            'status_anggota_id' => $riwayat['status'],
                            'tanggal_status'    => $riwayat['tanggal'],
                        ]);
                    } else {
                        // Jika ID null, buat data baru
                        KeluargaAnggotaStatusRecord::create([
                            'keluarga_anggota_id' => $keluarga_anggota->id,
                            'status_anggota_id'   => $riwayat['status'],
                            'tanggal_status'      => $riwayat['tanggal'],
                        ]);
                    }
                    // var_dump($riwayat);
                    if ($riwayat['status'] === 6) {
                        $is_wafat = 1;
                    }
                }
                if ($is_wafat == 1) {
                    $keluarga_anggota->update([
                        'is_wafat' => '1',
                        // 'tgl_wafat' => now(),
                    ]);
                } else {
                    $keluarga_anggota->update([
                        'is_wafat' => '0',
                        // 'tgl_wafat' => null,
                    ]);
                }

                // dd($is_wafat, $this->riwayatInputStatus);
            } else {
                // Jika user menghapus SEMUA baris di repeater, hapus semua riwayat milik anggota ini di database
                KeluargaAnggotaStatusRecord::where('keluarga_anggota_id', $keluarga_anggota->id)->delete();
            }
        });
        $this->reset();
        Toaster::success('Anggota Keluarga added successfully!');
        // return redirect()->route('anggota.index');
        return redirect()->to(route('anggota.index'));
        // $this->redirectRoute('anggota.edit', ['id' => $anggota_id], navigate: true);
        // $this->reset(['nama', 'jenis_kelamin', 'tanggal_lahir']);
    }

    public function render()
    {
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        return view('livewire.admin.anggotas.add-anggota');
    }
}
