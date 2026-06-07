<?php

namespace App\Livewire\Admin\Anggotas;

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
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;
use App\Models\HubunganKeluarga;
use App\Models\StatusAnggota;
use App\Models\KeluargaAnggotaStatusRecord;
use Illuminate\Support\Facades\DB;

#[Title('Edit Anggota Keluarga | Sidaman')]
class EditAnggota extends Component
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
    public $tanggal_status;

    public $anggota_details;
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


    public function mount($id)
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
        $this->loadEdit($id);
    }

    public function loadEdit($anggota_id)
    {
        $this->anggota_details = KeluargaAnggota::find($anggota_id);
        if (auth()->user()->role == 'majelis' && $this->anggota_details->keluarga->blok_id != auth()->user()->blok_id) {
            return redirect()->to(route('anggota.index'));
        }
        $this->fill([
            'keluarga_id' => $this->anggota_details->keluarga_id,
            'name' => $this->anggota_details->name,
            'jns_kelamin' => $this->anggota_details->jns_kelamin,
            'nomor_induk_gereja' => $this->anggota_details->nomor_induk_gereja,
            'hubungan_keluarga_id' => $this->anggota_details->hubungan_keluarga_id,
            'perkawinan_id' => $this->anggota_details->perkawinan_id,
            'tgl_lahir' => $this->anggota_details->tgl_lahir,
            'gol_darah_id' => $this->anggota_details->gol_darah_id,
            'ijazah_id' => $this->anggota_details->ijazah_id,
            'pekerjaan_id' => $this->anggota_details->pekerjaan_id,
            'pendapatan_id' => $this->anggota_details->pendapatan_id,
            'tempat_babtis_id' => $this->anggota_details->tempat_babtis_id,
            'tgl_babtis' => $this->anggota_details->tgl_babtis,
            'tempat_sidi_id' => $this->anggota_details->tempat_sidi_id,
            'tgl_sidi' => $this->anggota_details->tgl_sidi,
            'hobi_id' => $this->anggota_details->recordHobi->pluck('id')->toArray(),
            'aktifitas_pelayanan' => $this->anggota_details->aktifitas_pelayanan,
            'memiliki_bpjs_asuransi' => $this->anggota_details->memiliki_bpjs_asuransi,
            'penyakit_id' => $this->anggota_details->recordPenyakit->pluck('id')->toArray(),
            'domisili_alamat' => $this->anggota_details->domisili_alamat,
            'nomor_wa' => $this->anggota_details->nomor_wa,
            // 'is_wafat' => $this->anggota_details->is_wafat,
        ]);

        // Load latest status record if exists
        $records = $this->anggota_details->statusRecords()->latest('tanggal_status')->get()->toArray();
        $this->riwayatInputStatus = array_map(function ($record) {
            return [
                'id' => $record['id'],
                'status' => $record['status_anggota_id'],
                'tanggal' => $record['tanggal_status'],
            ];
        }, $records);
        if (empty($this->riwayatInputStatus)) {
            $this->addRiwayat();
        }
        // if ($latestStatusRecord) {
        //     $this->status_anggota_id = $latestStatusRecord->status_anggota_id;
        //     $this->tanggal_status = $latestStatusRecord->tanggal_status;
        // }
        // dd($latestStatusRecord);
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
        // dd($this->riwayatInputStatus);
        $this->validate([
            'keluarga_id' => 'required',
            'user_id' => 'nullable',
            'name' => 'required|string|max:255|unique:users,email,' . $this->anggota_details->user_id,
            'jns_kelamin' => 'required|in:L,P',
            'nomor_induk_gereja' => 'nullable|string|max:255',
            'hubungan_keluarga_id' => 'required',
            'perkawinan_id' => 'required',
            'tgl_lahir' => 'required|date',
            'gol_darah_id' => 'nullable',
            'ijazah_id' => 'required',
            'pekerjaan_id' => 'required',
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
            // 'tanggal_status' => 'required|date',
            // 'status_anggota_id' => 'required',

            // Validasi tambahan untuk Repeater Riwayat Status Anda
            'riwayatInputStatus' => 'nullable|array',
            'riwayatInputStatus.*.status' => 'required|exists:status_anggotas,id',
            'riwayatInputStatus.*.tanggal' => 'required|date',
        ], [
            // Custom message khusus untuk repeater riwayat status
            'riwayatInputStatus.*.status.required' => 'Status di tabel riwayat wajib diisi.',
            'riwayatInputStatus.*.tanggal.required' => 'Tanggal di tabel riwayat wajib diisi.',
        ]);


        // dd($this->hobi_id);
        DB::transaction(function () {
            User::where('id', $this->anggota_details->user_id)->update([
                'name' => $this->name,
                'email' => $this->name,
            ]);
            $keluarga_anggota = KeluargaAnggota::find($this->anggota_details->id);
            $keluarga_anggota->update([
                'keluarga_id' => $this->keluarga_id,
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
                'tgl_babtis' => ($this->tgl_babtis != '') ? $this->tgl_babtis : null,
                'tempat_sidi_id' => $this->tempat_sidi_id,
                'tgl_sidi' => ($this->tgl_sidi != '') ? $this->tgl_sidi : null,
                'aktifitas_pelayanan' => $this->aktifitas_pelayanan,
                'memiliki_bpjs_asuransi' => $this->memiliki_bpjs_asuransi,
                'domisili_alamat' => $this->domisili_alamat,
                'nomor_wa' => $this->nomor_wa,
                // 'hobi_id' => $this->hobi_id,
            ]);

            // // Create new status record if status changed
            // $latestStatusRecord = $keluarga_anggota->statusRecords()->latest('tanggal_status')->first();
            // if (!$latestStatusRecord || $latestStatusRecord->status_anggota_id != $this->status_anggota_id || $latestStatusRecord->tanggal_status != $this->tanggal_status) {
            //     KeluargaAnggotaStatusRecord::create([
            //         'keluarga_anggota_id' => $keluarga_anggota->id,
            //         'status_anggota_id' => $this->status_anggota_id,
            //         'tanggal_status' => $this->tanggal_status,
            //     ]);
            // }

            // dd($keluarga_anggota->recordHobi()->sync($this->hobi_id));
            $keluarga_anggota->recordHobi()->sync($this->hobi_id);
            $keluarga_anggota->recordPenyakit()->sync($this->penyakit_id);


            // Gunakan Database Transaction agar data aman (jika satu gagal, semua batal)
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

        // Reset form atau redirect setelah berhasil
        // session()->flash('success', 'Data Anggota dan Riwayat Status berhasil disimpan!');
        // return redirect()->to('/anggota'); // Sesuaikan route Anda

        $this->reset();
        Toaster::success('Anggota Keluarga updated successfully!');
        // return redirect()->route('anggota.index');
        return redirect()->to(route('anggota.index'));
        // $this->redirectRoute('anggota.edit', ['id' => $anggota_id], navigate: true);
        // $this->reset(['nama', 'jenis_kelamin', 'tanggal_lahir']);
    }

    public function render()
    {
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        return view('livewire.admin.anggotas.edit-anggota');
    }
}
