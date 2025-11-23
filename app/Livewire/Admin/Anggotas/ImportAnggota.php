<?php

namespace App\Livewire\Admin\Anggotas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Imports\AnggotaImport;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use App\Models\KeluargaAnggota;
use App\Models\KeluargaAnggotaDummy;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnggotaTemplateExport;


#[Title('Import Anggota | Sidaman')]
class ImportAnggota extends Component
{
    public function cancelImport(): void
    {
        $this->dispatch('show-delete-modal');
    }

    public function deleteConfirmed(): void
    {
        KeluargaAnggotaDummy::where('user_id_input', auth()->user()->id)->delete();

        Toaster::success('Data deleted successfully!');
        $this->dispatch('close-delete-modal');
    }

    use WithPagination;
    use WithFileUploads;

    public $menuName = "Anggota";

    public $fileImport;

    public $searchName = '';
    public $searchNIG = '';
    public $searchKeluarga = '';
    public $searchTglLahir = '';
    public $searchTgl_lahir_awal = '';
    public $searchTgl_lahir_akhir = '';

    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortField1 = 'name'; // Default kolom sorting

    public function submitImport()
    {
        session()->forget('import_anggota_errors');
        KeluargaAnggotaDummy::where('user_id_input', auth()->user()->id)->delete();

        $this->validate([
            'fileImport' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        // dd($this->fileImport);

        // $importer = new AnggotaImport;
        // Excel::import($importer, $this->fileImport)->first();

        $collections = Excel::toCollection(new AnggotaImport, $this->fileImport);
        // Ambil sheet pertama
        $firstSheet = $collections->first();
        // Jalankan logic kamu secara manual
        $importer = new AnggotaImport;
        $importer->collection($firstSheet);

        // Simpan error ke session jika ada
        if (!empty($importer->errors)) {
            session()->put('import_anggota_errors', $importer->errors);
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
        foreach (KeluargaAnggotaDummy::where('user_id_input', auth()->user()->id)->get() as $dummy) {
            $dummy->tgl_babtis = ($dummy->tgl_babtis != '') ? $dummy->tgl_babtis : null;
            $dummy->tgl_sidi = ($dummy->tgl_sidi != '') ? $dummy->tgl_sidi : null;
            $dummy->tgl_wafat = ($dummy->tgl_wafat != '') ? $dummy->tgl_wafat : null;
            if ($dummy->keluarga_anggota_id) {
                // update
                $keluarga_anggota = KeluargaAnggota::find($dummy->keluarga_anggota_id);
                $keluarga_anggota->update([
                    // 'keluarga_id' => $dummy->keluarga_id,
                    // 'name' => $dummy->name,
                    'jns_kelamin' => $dummy->jns_kelamin,
                    'nomor_induk_gereja' => $dummy->nomor_induk_gereja,
                    'hubungan_keluarga_id' => $dummy->hubungan_keluarga_id,
                    'perkawinan_id' => $dummy->perkawinan_id,
                    'tgl_lahir' => $dummy->tgl_lahir,
                    'gol_darah_id' => $dummy->gol_darah_id,
                    'ijazah_id' => $dummy->ijazah_id,
                    'pekerjaan_id' => $dummy->pekerjaan_id,
                    'pendapatan_id' => $dummy->pendapatan_id,
                    'tempat_babtis_id' => $dummy->tempat_babtis_id,
                    'tgl_babtis' => $dummy->tgl_babtis,
                    'tempat_sidi_id' => $dummy->tempat_sidi_id,
                    'tgl_sidi' => $dummy->tgl_sidi,
                    // 'hobi_id' => $dummy->hobi_id,
                    'aktifitas_pelayanan' => $dummy->aktifitas_pelayanan,
                    'memiliki_bpjs_asuransi' => $dummy->memiliki_bpjs_asuransi,
                    // 'penyakit_id' => $dummy->penyakit_id,
                    'domisili_alamat' => $dummy->domisili_alamat,
                    'nomor_wa' => $dummy->nomor_wa,
                    // 'is_wafat' => $dummy->is_wafat,
                    'tgl_wafat' => $dummy->tgl_wafat,
                    'status_anggota_id' => $dummy->status_anggota_id,
                ]);
            } else {
                // insert baru
                $keluarga_anggota = KeluargaAnggota::create([
                    'keluarga_id' => $dummy->keluarga_id,
                    'name' => $dummy->name,
                    'jns_kelamin' => $dummy->jns_kelamin,
                    'nomor_induk_gereja' => $dummy->nomor_induk_gereja,
                    'hubungan_keluarga_id' => $dummy->hubungan_keluarga_id,
                    'perkawinan_id' => $dummy->perkawinan_id,
                    'tgl_lahir' => $dummy->tgl_lahir,
                    'gol_darah_id' => $dummy->gol_darah_id,
                    'ijazah_id' => $dummy->ijazah_id,
                    'pekerjaan_id' => $dummy->pekerjaan_id,
                    'pendapatan_id' => $dummy->pendapatan_id,
                    'tempat_babtis_id' => $dummy->tempat_babtis_id,
                    'tgl_babtis' => $dummy->tgl_babtis,
                    'tempat_sidi_id' => $dummy->tempat_sidi_id,
                    'tgl_sidi' => $dummy->tgl_sidi,
                    // 'hobi_id' => $dummy->hobi_id,
                    'aktifitas_pelayanan' => $dummy->aktifitas_pelayanan,
                    'memiliki_bpjs_asuransi' => $dummy->memiliki_bpjs_asuransi,
                    // 'penyakit_id' => $dummy->penyakit_id,
                    'domisili_alamat' => $dummy->domisili_alamat,
                    'nomor_wa' => $dummy->nomor_wa,
                    'is_wafat' => $dummy->is_wafat,
                    'tgl_wafat' => $dummy->tgl_wafat,
                    'status_anggota_id' => $dummy->status_anggota_id,
                    // 'is_wafat' => '0',
                ]);
            }
            if (is_array($dummy->hobi_id)) {
                $keluarga_anggota->recordHobi()->sync($dummy->hobi_id);
            }

            // STEP 3 — Sync penyakit (JSON → pivot)
            if (is_array($dummy->penyakit_id)) {
                $keluarga_anggota->recordPenyakit()->sync($dummy->penyakit_id);
            }
        }
        KeluargaAnggotaDummy::where('user_id_input', auth()->user()->id)->delete();
        $this->dispatch('close-save-modal');
        Toaster::success('Import data saved successfully!');
    }

    public function exportTemplate()
    {
        return Excel::download(new AnggotaTemplateExport, 'template_import_anggota.xlsx');
    }

    public function mount()
    {
        Carbon::setLocale('id');
    }

    public function render()
    {
        $anggotas = $this->loadAnggotas();
        return view('livewire.admin.anggotas.import-anggota', compact('anggotas'));
    }

    public function loadAnggotas()
    {
        $query = KeluargaAnggotaDummy::query()->where('user_id_input', auth()->user()->id);

        if ($this->searchName) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }
        if ($this->searchNIG) {
            $query->where('nomor_induk_gereja', 'like', '%' . $this->searchNIG . '%');
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchKeluarga) {
            $query->where(function ($q) {
                $q->orWhereRelation('keluarga', 'name', 'like', '%' . $this->searchKeluarga . '%')
                    ->orWhereHas('keluarga.blok', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->searchKeluarga . '%');
                    });
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchTgl_lahir_awal) {
            $query->where('tgl_lahir', '>=', $this->searchTgl_lahir_awal);
        }

        if ($this->searchTgl_lahir_akhir) {
            $query->where('tgl_lahir', '<=', $this->searchTgl_lahir_akhir);
        }

        // Sorting
        if ($this->sortField1 === 'name') {
            $query->orderBy('name', $this->sortDirection1);
        }

        // Trigger frontend reactivity
        $this->dispatch('reinit-hsselect');

        // Pagination
        return $query->paginate($this->perPage);
    }


    // Filtering
    public function searchTgl_lahir_awal()
    {
        $this->resetPage();
    }
    public function searchTgl_lahir_akhir()
    {
        $this->resetPage();
    }
    public function updatingSearchName()
    {
        $this->resetPage();
    }
    public function updatingSearchKeluarga()
    {
        $this->resetPage();
    }
    public function searchNIG()
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
        } else {
            // Kalau klik field baru, set field dan arah default asc
            $this->sortField1 = $field;
            $this->sortDirection1 = 'asc';
        }

        $this->resetPage(); // reset ke halaman 1 biar hasilnya benar
    }
    public function paginationView()
    {
        return 'vendor.livewire.custom';
    }
}
