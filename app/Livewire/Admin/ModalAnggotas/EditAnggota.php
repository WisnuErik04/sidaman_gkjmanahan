<?php

namespace App\Livewire\Admin\ModalAnggotas;

use Flux\Flux;
use App\Models\Hobi;
use App\Models\Ijazah;
use Livewire\Component;
use App\Models\GolDarah;
use App\Models\Penyakit;
use App\Models\Pekerjaan;
use App\Models\Pendapatan;
use App\Models\Perkawinan;
use App\Models\TempatSidi;
use Livewire\Attributes\On;
use App\Models\TempatBabtis;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;
use App\Models\HubunganKeluarga;
use App\Models\User;

class EditAnggota extends Component
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

    public $anggota_details;
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

    #[On('livewire.admin.modal-anggotas.edit-anggota')] 
    public function editAnggota2($anggota_id, $keluarga_id)
    {
        // dd($anggota_id .' - '. $keluarga_id);
        $this->keluarga_id = $keluarga_id;
        $this->loadEdit($anggota_id);
        Flux::modal('edit-anggota')->show();
    }

    public function mount()
    {
        // $this->keluarga_id = $keluarga_id;
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
        
        // $this->anggota_details = KeluargaAnggota::find($anggota_id);
        // $this->loadEdit($anggota_id);
    }
    
    public function loadEdit($anggota_id){
        $this->anggota_details = KeluargaAnggota::find($anggota_id);
        $this->user_id = $this->anggota_details->user_id;

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
            'hobi_id' => $this->anggota_details->hobi_id,
            'aktifitas_pelayanan' => $this->anggota_details->aktifitas_pelayanan,
            'memiliki_bpjs_asuransi' => $this->anggota_details->memiliki_bpjs_asuransi,
            'penyakit_id' => $this->anggota_details->penyakit_id,
            'domisili_alamat' => $this->anggota_details->domisili_alamat,
            'nomor_wa' => $this->anggota_details->nomor_wa,
        ]);
    }

    public function saveAnggota()
    {
        // $us = $this->user_id;
        $this->validate([
            'keluarga_id' => 'required',
            'name' => 'required|string|max:255|unique:users,email,'.$this->user_id ,
            // 'name' => "required|string|max:255|unique:users,email,{$us}",
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
        
        
        User::find($this->anggota_details->user_id)->update([
            'name' => $this->name,
            'email' => $this->name,
        ]);
        // dd($this->anggota_details->user_id);

            KeluargaAnggota::find($this->anggota_details->id)->update([
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
        Toaster::success('Anggota Keluarga updated successfully!');
        $this->redirectRoute('keluarga.edit', ['id' => $keluarga_id], navigate: true);
        // $this->redirectRoute('anggota.index', ['id' => $keluarga_id], navigate: true);
        Flux::modal('edit-anggota')->close();
        // $this->reset(['nama', 'jenis_kelamin', 'tanggal_lahir']);
    }
    
    public function render()
    {
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        // $this->redirectRoute('keluarga.edit', ['id' => $this->keluarga_id], navigate: true);
        return view('livewire.admin.modal-anggotas.edit-anggota');
    }
}
