<?php

namespace App\Livewire\Admin\ModalAnggotas;

use Flux\Flux;
use App\Models\Hobi;
use App\Models\User;
use App\Models\Ijazah;
use App\Models\Anggota;
use Livewire\Component;
use App\Models\GolDarah;
use App\Models\Penyakit;
use App\Models\Pekerjaan;
use App\Models\Pendapatan;
use App\Models\Perkawinan;
use App\Models\TempatSidi;
use App\Models\TempatBabtis;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;
use App\Models\HubunganKeluarga;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TambahAnggota extends Component
{
    public $menuName = 'Anggota';
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
        $hobi_id,
        $aktifitas_pelayanan,
        $memiliki_bpjs_asuransi,
        $penyakit_id,
        $domisili_alamat,
        $nomor_wa;

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

    public function mount($keluarga_id)
    {
        $this->keluarga_id = $keluarga_id;
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
        
    }

    public function saveAnggota()
    {
        $this->validate([
            'keluarga_id' => 'required',
            'user_id' => 'nullable',
            'name' => 'required|string|max:255|unique:users,email', 
            'jns_kelamin' => 'required|in:L,P',
            'nomor_induk_gereja' => 'required|string|max:255',
            'hubungan_keluarga_id' => 'required',
            'perkawinan_id' => 'required',
            'tgl_lahir' => 'required|date',
            'gol_darah_id' => 'required',
            'ijazah_id' => 'required',
            'pekerjaan_id' => 'required',
            'pendapatan_id' => 'required',
            'tempat_babtis_id' => 'required',
            'tgl_babtis' => 'required|date',
            'tempat_sidi_id' => 'required',
            'tgl_sidi' => 'required|date',
            'hobi_id' => 'required',
            'aktifitas_pelayanan' => 'required',
            'memiliki_bpjs_asuransi' => 'required|in:1,2',
            'penyakit_id' => 'required',
            'domisili_alamat' => 'required|in:1,2',
            'nomor_wa' => 'string|max:12',
        ]);

     
            $user = User::create([
                'name' => $this->name,
                'email' => $this->name,
                'password' => Hash::make('12345678'),
                'role' => 'warga',
            ]);

            KeluargaAnggota::create([
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
                'hobi_id' => $this->hobi_id,
                'aktifitas_pelayanan' => $this->aktifitas_pelayanan,
                'memiliki_bpjs_asuransi' => $this->memiliki_bpjs_asuransi,
                'penyakit_id' => $this->penyakit_id,
                'domisili_alamat' => $this->domisili_alamat,
                'nomor_wa' => $this->nomor_wa,
            ]);
       
        $keluarga_id = $this->keluarga_id;
        $this->reset();
        Toaster::success('Anggota Keluarga added successfully!');
        $this->redirectRoute('keluarga.edit', ['id' => $keluarga_id], navigate: true);
        Flux::modal('create-anggota')->close();
        // $this->reset(['nama', 'jenis_kelamin', 'tanggal_lahir']);
    }
    
    public function render()
    {
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        // $this->redirectRoute('keluarga.edit', ['id' => $this->keluarga_id], navigate: true);
        return view('livewire.admin.modal-anggotas.tambah-anggota');
    }
}
