<?php

namespace App\Livewire\Admin\Keluargas;

use App\Models\Blok;
use App\Models\User;
use Livewire\Component;
use App\Models\Keluarga;
use App\Models\JarakRumah;
use Livewire\WithPagination;
use App\Models\KeluargaDummy;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Imports\KeluargaImport;
use App\Models\KeluargaAnggota;
use Livewire\Attributes\Validate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KeluargaTemplateExport;

#[Title('Import Keluarga | Sidaman')]
class ImportKeluarga extends Component
{
    public function cancelImport(): void
    {
        $this->dispatch('show-delete-modal');
    }

    public function deleteConfirmed(): void
    {
            KeluargaDummy::where('user_id_input', auth()->user()->id)->delete();
        
            Toaster::success('Data deleted successfully!');
            $this->dispatch('close-delete-modal');
        
    }

    // public function delete($id)
    // {
    //     KeluargaAnggota::find('keluarga_id', $id)->delete();
    //     KeluargaDummy::find($id)->delete();
    //     Toaster::success('keluarga deleted successfully!');
    //     return redirect()->route('keluarga.index');
    // }

    use WithPagination;
    use WithFileUploads;

    public $menuName = "Keluarga";

    public $bloks = [];
    public $jarakRumahs = [];

    public $searchBlok = '';

    public $fileImport;

    public $searchName = '';
    public $searchAlamat = '';
    public $searchJarak = '';

    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortDirection2 = 'asc';    // Default arah sorting
    public $sortField1 = 'blok'; // Default kolom sorting
    public $sortField2 = 'name'; // Default kolom sorting

    public function submitImport()
    {
        session()->forget('import_keluarga_errors');
        KeluargaDummy::where('user_id_input', auth()->user()->id)->delete();

        $this->validate([
            'fileImport' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        // dd('asasa');
        
        // $importer = new KeluargaImport;
        // Excel::import($importer, $this->fileImport)->first();

        $collections = Excel::toCollection(new KeluargaImport, $this->fileImport);
        // Ambil sheet pertama
        $firstSheet = $collections->first();
        // Jalankan logic kamu secara manual
        $importer = new KeluargaImport;
        $importer->collection($firstSheet);

        // Simpan error ke session jika ada
        if (!empty($importer->errors)) {
            session()->put('import_keluarga_errors', $importer->errors);
            // dd($importer->errors);
        }        
        $this->reset();
        Toaster::success('Data imported successfully!');
    }

    public function saveImport(): void
    {
        $this->dispatch('show-save-modal');
    }
    public function saveConfirmed()
    {
        foreach (KeluargaDummy::where('user_id_input', auth()->user()->id)->get() as $dummy) {
            if ($dummy->keluarga_id) {
                // update
                Keluarga::find($dummy->keluarga_id)->update([
                    // 'blok_id' => $dummy->blok_id,
                    // 'name' => $dummy->name,
                    'alamat_detail' => $dummy->alamat_detail,
                    'alamat_rt' => $dummy->alamat_rt,
                    'alamat_rw' => $dummy->alamat_rw,
                    'alamat_desa_kelurahan' => $dummy->alamat_desa_kelurahan,
                    'alamat_kecamatan' => $dummy->alamat_kecamatan,
                    'alamat_kab_kota' => $dummy->alamat_kab_kota,
                    'alamat_provinsi' => $dummy->alamat_provinsi,
                    'jarak_rumah_id' => $dummy->jarak_rumah_id,
                ]);
            } else {
                // insert baru
                Keluarga::create([
                    'blok_id' => $dummy->blok_id,
                    'name' => $dummy->name,
                    'alamat_detail' => $dummy->alamat_detail,
                    'alamat_rt' => $dummy->alamat_rt,
                    'alamat_rw' => $dummy->alamat_rw,
                    'alamat_desa_kelurahan' => $dummy->alamat_desa_kelurahan,
                    'alamat_kecamatan' => $dummy->alamat_kecamatan,
                    'alamat_kab_kota' => $dummy->alamat_kab_kota,
                    'alamat_provinsi' => $dummy->alamat_provinsi,
                    'jarak_rumah_id' => $dummy->jarak_rumah_id,
                ]);
            }
        }
        KeluargaDummy::where('user_id_input', auth()->user()->id)->delete();
        $this->dispatch('close-save-modal');
        Toaster::success('Import data saved successfully!');
    }

    public function exportTemplate()
    {
        return Excel::download(new KeluargaTemplateExport, 'template_import_keluarga.xlsx');    
    }

    public function mount()
    {
        $this->bloks = Blok::all();
        if (auth()->user()->role == 'majelis'){
            $this->bloks = Blok::where('id', auth()->user()->blok_id)->get();
        }
        $this->jarakRumahs = JarakRumah::all();
    }

    public function render()
    {

        // dd(session('import_keluarga_errors'));
        $keluargas = $this->loadKeluargas();
        return view('livewire.admin.keluargas.import-keluarga', compact('keluargas'));
        // return view('livewire.teacher.keluargas.import-keluarga',[
        //     'keluargas' => KeluargaDummy::all()
        // ]);
    }

    public function loadKeluargas()
    {
        $query = KeluargaDummy::query();

        $query->where('user_id_input', auth()->user()->id);
        // Filter nama keluarga
        if ($this->searchName) {
            $query->where('keluarga_dummies.name', 'like', '%' . $this->searchName . '%');
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchAlamat) {
            $query->where(function ($q) {
                $q->where('alamat_detail', 'like', '%' . $this->searchAlamat . '%')
                    ->orWhere('alamat_rt', 'like', '%' . $this->searchAlamat . '%')
                    ->orWhere('alamat_rw', 'like', '%' . $this->searchAlamat . '%')
                    ->orWhereRelation('desaKelurahan', 'name', 'like', '%' . $this->searchAlamat . '%')
                    ->orWhereRelation('kecamatan', 'name', 'like', '%' . $this->searchAlamat . '%')
                    ->orWhereRelation('kabKota', 'name', 'like', '%' . $this->searchAlamat . '%')
                    ->orWhereRelation('provinsi', 'name', 'like', '%' . $this->searchAlamat . '%');
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchBlok) {
            $query->whereIn('blok_id', $this->searchBlok);
        }
        if ($this->searchJarak) {
            $query->where('jarak_rumah_id', $this->searchJarak);
        }

        // Sorting
        if ($this->sortField1 === 'blok') {
            $query->join('bloks', 'keluarga_dummies.blok_id', '=', 'bloks.id')
                ->orderBy('bloks.name', $this->sortDirection1)
                ->select('keluarga_dummies.*');
        }
        if ($this->sortField2 === 'name') {
            $query->orderBy('name', $this->sortDirection2);
        }

        // Trigger frontend reactivity
        $this->dispatch('reinit-hsselect');

        // Pagination
        return $query->paginate($this->perPage);
    }


    // Filtering
    public function updatingSearchBlok()
    {
        $this->resetPage();
    }
    public function updatingSearchName()
    {
        $this->resetPage();
    }
    public function updatingSearchAlamat()
    {
        $this->resetPage();
    }
    public function updatingSearchJarak()
    {
        $this->resetPage();
    }

    // Pagination
    public function setPerPage($number)
    {
        $this->perPage = $number;
        $this->resetPage();
    }
    public function sortBy($field)
    {
        if ($this->sortField1 === $field) {
            // Kalau klik field yang sama, toggle arah
            $this->sortDirection1 = $this->sortDirection1 === 'asc' ? 'desc' : 'asc';
        } else if ($this->sortField2 === $field) {
            // Kalau klik field yang sama, toggle arah
            $this->sortDirection2 = $this->sortDirection2 === 'asc' ? 'desc' : 'asc';
        } else {
            // Kalau klik field baru, set field dan arah default asc
            $this->sortField1 = $field;
            $this->sortDirection1 = 'asc';
            $this->sortField2 = $field;
            $this->sortDirection2 = 'asc';
        }

        $this->resetPage(); // reset ke halaman 1 biar hasilnya benar
    }
    public function paginationView()
    {
        return 'vendor.livewire.custom';
    }
}
