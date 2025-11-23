<?php

namespace App\Livewire\Warga\Anggotas;

use App\Models\Blok;
use App\Models\Wilayah;
use Livewire\Component;
use App\Models\Keluarga;
use App\Models\JarakRumah;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;

#[Title('View Anggota Keluarga | Sidaman')]
class AnggotaView extends Component
{
    public $menuName = 'Anggota Keluarga';
    public $keluarga_details, $anggotas;
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
        $this->anggotas = KeluargaAnggota::where('user_id', auth()->user()->id)->first();
        // $id = $id[0];
        // dd($this->anggotas->name);
        $this->provinsis = Wilayah::whereRaw('CHAR_LENGTH(kode) = 2')->orderBy('name', 'ASC')->get();
        $this->bloks = Blok::all();
        $this->jarakRumahs = JarakRumah::all(); 
        
        // $this->anggotas = KeluargaAnggota::find($id);
        $this->keluarga_details = Keluarga::find($this->anggotas->keluarga_id);
        // if (auth()->user()->role === 'majelis' && $this->keluarga_details->blok_id !== auth()->user()->blok_id) {
        //     return redirect()->route('anggota.index');
        // };
        $this->anggotas = KeluargaAnggota::with([
            'status',
            'hubunganKeluarga',
            'perkawinan',
            'golDarah',
            'ijazah',
            'pekerjaan',
            'pendapatan',
            'tempatBabtis',
            'tempatSidi',
            // 'hobi',
            // 'penyakit',
            'recordPenyakit',
            'recordHobi',
        ])->where('keluarga_id', $this->anggotas->keluarga_id)
            ->orderBy('hubungan_keluarga_id')->orderBy('tgl_lahir')->get();
        $this->loadEdit();
        // $this->anggotas = KeluargaAnggota::where('keluarga_id', $this->anggotas->keluarga_id)
        //     ->orderBy('hubungan_keluarga_id')->orderBy('tgl_lahir')->get();
        // $this->loadEdit();
    }

    public function loadEdit(){
        $this->fill([
            'blok_id' => $this->keluarga_details->blok_id,
            'name' => $this->keluarga_details->name,
            'alamat_detail' => $this->keluarga_details->alamat_detail,
            'alamat_rt' => $this->keluarga_details->alamat_rt,
            'alamat_rw' => $this->keluarga_details->alamat_rw,
            'alamat_desa_kelurahan' => $this->keluarga_details->alamat_desa_kelurahan,
            'alamat_kecamatan' => $this->keluarga_details->alamat_kecamatan,
            'alamat_kab_kota' => $this->keluarga_details->alamat_kab_kota,
            'alamat_provinsi' => $this->keluarga_details->alamat_provinsi,
            'jarak_rumah_id' => $this->keluarga_details->jarak_rumah_id,
        ]);
    }

    // public function save(){
    //     $this->validate([
    //         'blok_id' => 'required',
    //         'name' => 'required|string|max:255',
    //         'alamat_detail' => 'required|string|max:255',
    //         'alamat_rt' => 'required|string|min:3|max:3',
    //         'alamat_rw' => 'required|string|min:3|max:3',
    //         'alamat_desa_kelurahan' => 'required',
    //         'alamat_kecamatan' => 'required',
    //         'alamat_kab_kota' => 'required',
    //         'alamat_provinsi' => 'required',
    //         'jarak_rumah_id' => 'required',
    //     ]);

    //     Keluarga::find($this->keluarga_details->id)->update([
    //         'blok_id' => $this->blok_id,
    //         'name' => $this->name,
    //         'alamat_detail' => $this->alamat_detail,
    //         'alamat_rt' => $this->alamat_rt,
    //         'alamat_rw' => $this->alamat_rw,
    //         'alamat_desa_kelurahan' => $this->alamat_desa_kelurahan,
    //         'alamat_kecamatan' => $this->alamat_kecamatan,
    //         'alamat_kab_kota' => $this->alamat_kab_kota,
    //         'alamat_provinsi' => $this->alamat_provinsi,
    //         'jarak_rumah_id' => $this->jarak_rumah_id,
    //     ]);

    //     $this->reset();

    //     Toaster::success('keluarga updated successfully!');

    //     // return redirect()->route('keluarga.index');
    //     return redirect()->to(route('keluarga.index'));
    //     // return redirect('/keluarga-list');
    // }

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

        return view('livewire.warga.anggotas.anggota-view', compact('kabupatenKotas', 'kecamatans', 'desaKelurahans'));
        // return view('livewire.admin.keluargas.view-keluarga', compact('bloks', 'jarakRumahs', 'kabupatenKotas', 'kecamatans', 'desaKelurahans'));
    }

}