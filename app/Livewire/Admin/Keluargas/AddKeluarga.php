<?php

namespace App\Livewire\Admin\Keluargas;

use App\Models\Blok;
use App\Models\Grade;
use App\Models\JarakRumah;
use App\Models\Keluarga;
use App\Models\Student;
use App\Models\Wilayah;
use Livewire\Component;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;

#[Title('Tambah Keluarga | Sidaman')]
class AddKeluarga extends Component
{
    public $menuName = 'Keluarga';
    public $blok_id = '';
    public $name = '';
    public $alamat_detail = '';
    public $alamat_rt = '';
    public $alamat_rw = '';
    public $alamat_desa_kelurahan = '';
    public $alamat_kecamatan = '';
    public $alamat_kab_kota = '';
    public $alamat_provinsi = '';
    public $jarak_rumah_id = '';
    
    // public $bloks = [];
    public $provinsis = [];
    public $bloks = [];
    public $jarakRumahs = [];
    // public $alamat_provinsi = '';
    // public $alamat_kab_kota = '';
    // public $alamat_kecamatan = '';
    // public $alamat_desa_kelurahan = '';
    
    public function mount(){
        $this->provinsis = Wilayah::whereRaw('CHAR_LENGTH(kode) = 2')->orderBy('name', 'ASC')->get();
        $this->bloks = Blok::all();
        if (auth()->user()->role == 'majelis'){
            $this->bloks = Blok::where('id', auth()->user()->blok_id)->get();
        }
        $this->jarakRumahs = JarakRumah::all();

    }

    public function save(){
        $this->validate([
            'blok_id' => 'required',
            'name' => 'required|string|max:255',
            'alamat_detail' => 'required|string|max:255',
            'alamat_rt' => 'required|string|min:3|max:3',
            'alamat_rw' => 'required|string|min:3|max:3',
            'alamat_desa_kelurahan' => 'required',
            'alamat_kecamatan' => 'required',
            'alamat_kab_kota' => 'required',
            'alamat_provinsi' => 'required',
            'jarak_rumah_id' => 'required',
        ]);

        Keluarga::create([
            'blok_id' => $this->blok_id,
            'name' => $this->name,
            'alamat_detail' => $this->alamat_detail,
            'alamat_rt' => $this->alamat_rt,
            'alamat_rw' => $this->alamat_rw,
            'alamat_desa_kelurahan' => $this->alamat_desa_kelurahan,
            'alamat_kecamatan' => $this->alamat_kecamatan,
            'alamat_kab_kota' => $this->alamat_kab_kota,
            'alamat_provinsi' => $this->alamat_provinsi,
            'jarak_rumah_id' => $this->jarak_rumah_id,
        ]);

        $this->reset();

        Toaster::success('Keluarga added successfully!');

        // return redirect()->route('keluarga.index');
        return redirect()->to(route('keluarga.index'));
        // return redirect('/keluarga-list');
    }

    public function render()
    {

        // $bloks = Blok::all();
        // $jarakRumahs = JarakRumah::all();
        $kabupatenKotas = $this->alamat_provinsi
            ? Wilayah::whereRaw('CHAR_LENGTH(kode) = 5')->where('kode', 'like', $this->alamat_provinsi . '.%')->orderBy('name', 'ASC')->get()
            : collect();
        $kecamatans = $this->alamat_kab_kota
            ? Wilayah::whereRaw('CHAR_LENGTH(kode) = 8')->where('kode', 'like', $this->alamat_kab_kota . '.%')->orderBy('name', 'ASC')->get()
            : collect();
        $desaKelurahans = $this->alamat_kecamatan
            ? Wilayah::whereRaw('CHAR_LENGTH(kode) = 13')->where('kode', 'like', $this->alamat_kecamatan . '.%')->orderBy('name', 'ASC')->get()
            : collect();
            $this->dispatch('reinit-hsselect'); // 🔥 Dispatch event ke JS

        return view('livewire.admin.keluargas.add-keluarga', compact('kabupatenKotas', 'kecamatans', 'desaKelurahans'));
        // return view('livewire.admin.keluargas.add-keluarga', compact('bloks', 'jarakRumahs', 'kabupatenKotas', 'kecamatans', 'desaKelurahans'));
    }

    public function updatedAlamatProvinsi()
    {
        $this->alamat_kab_kota = $this->alamat_kecamatan = $this->alamat_desa_kelurahan = '';
    }

    public function updatedAlamatKabKota()
    {
        $this->alamat_kecamatan = $this->alamat_desa_kelurahan = '';
    }

    public function updatedAlamatKecamatan()
    {
        $this->alamat_desa_kelurahan = '';
    }

    
    public function updatedAlamatRt($value)
    {
        // Hanya angka
        $numeric = preg_replace('/\D/', '', $value);
        $realNumber = substr(ltrim($numeric, '0'), 0);
        // Pad jadi 3 digit
        $this->alamat_rt =  str_pad(substr($realNumber, 0, 3), 3, '0', STR_PAD_LEFT);
    }

    public function updatedAlamatRw($value)
    {
        // Hanya angka
        $numeric = preg_replace('/\D/', '', $value);
        $realNumber = substr(ltrim($numeric, '0'), 0);
        // Pad jadi 3 digit
        $this->alamat_rw =  str_pad(substr($realNumber, 0, 3), 3, '0', STR_PAD_LEFT);
    }
}
