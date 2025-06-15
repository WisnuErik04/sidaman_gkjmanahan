<?php

namespace App\Livewire\Warga\Anggotas;

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
#[Title('Anggota Keluarga | Sidaman')]

class Anggota extends Component
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
        $hobi_id,
        $aktifitas_pelayanan,
        $memiliki_bpjs_asuransi,
        $penyakit_id,
        $domisili_alamat,
        $nomor_wa,
        $is_wafat,
        $tgl_wafat;

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

    public function mount()
    {
        $this->keluargas = Keluarga::all();
        // if (auth()->user()->role == 'majelis'){
            // $this->keluargas = Keluarga::where('blok_id', auth()->user()->blok_id)->get();
        // }
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
        $this->loadEdit();
    }

    public function loadEdit()
    {
        $this->anggota_details = KeluargaAnggota::where('user_id', auth()->user()->id)->first();
        // if (auth()->user()->role == 'majelis' && $this->anggota_details->keluarga->blok_id != auth()->user()->blok_id){
        //     return redirect()->to(route('anggota.index'));
        // }
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
            'is_wafat' => $this->anggota_details->is_wafat,
            'tgl_wafat' => $this->anggota_details->tgl_wafat,
        ]);
    }

    public function saveAnggota()
    {
        $this->validate([
            'keluarga_id' => 'required',
            'user_id' => 'nullable',
            'name' => 'required|string|max:255|unique:users,email,'.$this->anggota_details->user_id,
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
            'is_wafat' => 'in:1,0|nullable',
            'tgl_wafat' => 'date|nullable',
        ]);


        User::find($this->anggota_details->user_id)->update([
            'name' => $this->name,
            'email' => $this->name,
        ]);

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
            'is_wafat' => $this->is_wafat ?? '0',
            'tgl_wafat' => $this->tgl_wafat,
        ]);

        $this->reset();
        Toaster::success('Anggota Keluarga updated successfully!');
        // return redirect()->route('anggota.index');
        return redirect()->to(route('warga_anggota.index'));
        // $this->redirectRoute('anggota.edit', ['id' => $anggota_id], navigate: true);
        // $this->reset(['nama', 'jenis_kelamin', 'tanggal_lahir']);
    }

    public function render()
    {
        $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        return view('livewire.warga.anggotas.anggota');
    }
}
