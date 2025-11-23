<?php

namespace App\Livewire\Admin\ExportAnggota;

use Flux\Flux;
use App\Models\Blok;
use App\Models\Hobi;
use App\Models\Ijazah;
use Livewire\Component;
use App\Models\GolDarah;
use App\Models\Penyakit;
use App\Models\Pekerjaan;
use App\Models\Pendapatan;
use App\Models\Perkawinan;
use App\Models\TempatSidi;
use App\Models\TempatBabtis;
use Livewire\WithPagination;
use App\Exports\JemaatExport;
use App\Models\StatusAnggota;
use App\Exports\AnggotaExport;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use App\Models\KeluargaAnggota;
use App\Models\HubunganKeluarga;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Title('Data Anggota | Sidaman')]
class ListAnggota extends Component
{
    use WithPagination;
    public $menuName = "Anggota";

    public $searchName = '';
    public $searchNIG = '';
    public $searchKeluarga = '';
    public $searchTglLahir = '';
    public $searchTgl_lahir_awal = '';
    public $searchTgl_lahir_akhir = '';
    public $searchTgl_ulang_tahun_awal = '';
    public $searchTgl_ulang_tahun_akhir = '';
    public $searchHubunganKeluarga = '';
    public $searchPerkawinan = '';
    public $searchGolDarah = '';
    public $searchIjazah = '';
    public $searchPekerjaan = '';
    public $searchPendapatan = '';
    public $searchTempatBabtis = '';
    public $searchTempatSidi = '';
    public $searchHobi = '';
    public $searchPenyakit = '';
    public $searchTgl_babtis_awal = '';
    public $searchTgl_babtis_akhir = '';
    public $searchTgl_sidi_awal = '';
    public $searchTgl_sidi_akhir = '';
    public $searchBlok = '';
    public $searchGenerasi = '';
    public $searchStatus = '';
    public $searchKelompokUsia = '';

    public $hubunganKeluargas;
    public $perkawinans;
    public $golDarahs;
    public $ijazahs;
    public $pekerjaans;
    public $pendapatans;
    public $tempatBabtises;
    public $tempatSidis;
    public $hobis;
    public $penyakits;
    public $bloks = [];
    public $generasis;
    public $statuses;
    public $kelompokUsias;

    public $perPage = 10;
    public $sortDirection1 = 'asc';    // Default arah sorting
    public $sortField1 = 'name'; // Default kolom sorting

    public function mount()
    {
        Carbon::setLocale('id');
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
        $this->searchStatus = ['1', '2', '3', '4'];
        // $this->generasis = [
        //     0 => [
        //         'id' => 1,
        //         'name' => '<1946',
        //         'tahun_awal' => 0,
        //         'tahun_akhir' => 1945,
        //     ],
        //     1 => [
        //         'id' => 2,
        //         'name' => 'Baby Boomers (1946 - 1964)',
        //         'tahun_awal' => 1946,
        //         'tahun_akhir' => 1964,
        //     ],
        //     2 => [
        //         'id' => 3,
        //         'name' => 'Generasi X (1965 - 1980)',
        //         'tahun_awal' => 1965,
        //         'tahun_akhir' => 1980,
        //     ],
        //     3 => [ 
        //         'id' => 4,
        //         'name' => 'Gen Y (1981 - 1994)',
        //         'tahun_awal' => 1981,
        //         'tahun_akhir' => 1994,
        //     ], 
        //     4 => [
        //         'id' => 5,
        //         'name' => 'Gen Z (1995 - 2010)',
        //         'tahun_awal' => 1995,
        //         'tahun_akhir' => 2010,
        //     ],
        //     5 => [
        //         'id' => 6,
        //         'name' => 'Gen Alpha (2011 - sekarang)',
        //         'tahun_awal' => 2011,
        //         'tahun_akhir' => date('Y'),
        //     ]
        // ];

        $this->generasis = collect([
            (object)[
                'id' => 1,
                'name' => '<1946',
                'tahun_awal' => 0,
                'tahun_akhir' => 1945,
            ],
            (object)[
                'id' => 2,
                'name' => 'Baby Boomers (1946 - 1964)',
                'tahun_awal' => 1946,
                'tahun_akhir' => 1964,
            ],
            (object)[
                'id' => 3,
                'name' => 'Generasi X (1965 - 1980)',
                'tahun_awal' => 1965,
                'tahun_akhir' => 1980,
            ],
            (object)[
                'id' => 4,
                'name' => 'Gen Y (1981 - 1994)',
                'tahun_awal' => 1981,
                'tahun_akhir' => 1994,
            ],
            (object)[
                'id' => 5,
                'name' => 'Gen Z (1995 - 2010)',
                'tahun_awal' => 1995,
                'tahun_akhir' => 2010,
            ],
            (object)[
                'id' => 6,
                'name' => 'Gen Alpha (2011 - sekarang)',
                'tahun_awal' => 2011,
                'tahun_akhir' => date('Y'),
            ],
        ]);

        $this->kelompokUsias = collect([
            (object)[
                'id' => 1,
                'name' => 'Anak - anak (< 13 Tahun)',
                "min_age" => 0,
                "max_age" => 12,
            ],
            (object)[
                'id' => 2,
                'name' => 'Remaja (13 - 17 Tahun)',
                "min_age" => 13,
                "max_age" => 17,
            ],
            (object)[
                'id' => 3,
                'name' => 'Pemuda (18 - 30 Tahun)',
                "min_age" => 18,
                "max_age" => 30,
            ],
            (object)[
                'id' => 4,
                'name' => 'Dewasa (31 - 60 Tahun)',
                "min_age" => 31,
                "max_age" => 60,
            ],
            (object)[
                'id' => 5,
                'name' => 'Lansia (> 60 Tahun)',
                "min_age" => 61,
                "max_age" => null,
            ]
        ]);


        $this->bloks = Blok::all();
        if (auth()->user()->role == 'majelis') {
            $this->bloks = Blok::where('id', auth()->user()->blok_id)->get();
        }
    }

    public function render()
    {
        $anggotas = $this->loadanggotas();
        return view('livewire.admin.export-anggota.list-anggota', compact('anggotas'));
    }

    public function loadAnggotas()
    {
        $query = KeluargaAnggota::query();

        // Filter nama anggota
        if (auth()->user()->role == 'majelis') {
            $query->whereRelation('keluarga', 'blok_id', auth()->user()->blok_id)->get();
        }
        if ($this->searchName) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }
        if ($this->searchNIG) {
            $query->where('nomor_induk_gereja', 'like', '%' . $this->searchNIG . '%');
        }

        if ($this->searchHubunganKeluarga) {
            $query->whereIn('hubungan_keluarga_id', $this->searchHubunganKeluarga);
        }
        if ($this->searchPerkawinan) {
            $query->whereIn('perkawinan_id', $this->searchPerkawinan);
        }
        if ($this->searchGolDarah) {
            $query->whereIn('gol_darah_id', $this->searchGolDarah);
        }
        if ($this->searchIjazah) {
            $query->whereIn('ijazah_id', $this->searchIjazah);
        }
        if ($this->searchPekerjaan) {
            $query->whereIn('pekerjaan_id', $this->searchPekerjaan);
        }
        if ($this->searchPendapatan) {
            $query->whereIn('pendapatan_id', $this->searchPendapatan);
        }
        if ($this->searchTempatBabtis) {
            $query->whereIn('tempat_babtis_id', $this->searchTempatBabtis);
        }
        if ($this->searchTempatSidi) {
            $query->whereIn('tempat_sidi_id', $this->searchTempatSidi);
        }
        if ($this->searchHobi) {
            $hobiIds = $this->searchHobi;
            $query->whereHas('recordHobi', function ($hobiQuery) use ($hobiIds) {
                $hobiQuery->whereIn('hobi_id', $hobiIds);
            });
        }
        if ($this->searchPenyakit) {
            $penyakitIds = $this->searchPenyakit;
            $query->whereHas('recordPenyakit', function ($penyakitQuery) use ($penyakitIds) {
                $penyakitQuery->whereIn('penyakit_id', $penyakitIds);
            });
        }
        // if ($this->searchPenyakit) {
        //     $query->whereIn('penyakit_id', $this->searchPenyakit);
        // }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchKeluarga) {
            $query->where(function ($q) {
                $q->orWhereRelation('keluarga', 'name', 'like', '%' . $this->searchKeluarga . '%')
                    ->orWhereHas('keluarga.blok', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->searchKeluarga . '%');
                    });
            });
        }

        if ($this->searchBlok) {
            $query->whereHas('keluarga.blok', function ($q) {
                $q->whereIn('id', $this->searchBlok);
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->searchTgl_lahir_awal) {
            $query->where('tgl_lahir', '>=', $this->searchTgl_lahir_awal);
        }
        if ($this->searchTgl_lahir_akhir) {
            $query->where('tgl_lahir', '<=', $this->searchTgl_lahir_akhir);
        }

        if ($this->searchTgl_ulang_tahun_awal && $this->searchTgl_ulang_tahun_akhir) {
            $awal = date('m-d', strtotime($this->searchTgl_ulang_tahun_awal));
            $akhir = date('m-d', strtotime($this->searchTgl_ulang_tahun_akhir));

            if ($awal <= $akhir) {
                // Range normal (misal 08-20 s/d 08-25)
                $query->whereRaw("DATE_FORMAT(tgl_lahir, '%m-%d') BETWEEN ? AND ?", [$awal, $akhir]);
            } else {
                // Range lintas tahun (misal 12-20 s/d 01-10)
                $query->where(function ($q) use ($awal, $akhir) {
                    $q->whereRaw("DATE_FORMAT(tgl_lahir, '%m-%d') >= ?", [$awal])
                        ->orWhereRaw("DATE_FORMAT(tgl_lahir, '%m-%d') <= ?", [$akhir]);
                });
            }
        }

        if ($this->searchGenerasi) {
            $query->where(function ($q) {
                foreach ($this->searchGenerasi as $genId) {
                    $generasi = $this->generasis->firstWhere('id', $genId);
                    if ($generasi) {
                        $tahunAwal = $generasi->tahun_awal;
                        $tahunAkhir = $generasi->tahun_akhir;

                        $q->orWhere(function ($sub) use ($tahunAwal, $tahunAkhir) {
                            $sub->whereYear('tgl_lahir', '>=', $tahunAwal)
                                ->whereYear('tgl_lahir', '<=', $tahunAkhir);
                        });
                    }
                }
            });
        }

        if ($this->searchKelompokUsia) {
            $today = now();
            $query->where(function ($q) use ($today) {
                foreach ($this->searchKelompokUsia as $kelUsiaId) {
                    $kelompokUsia = $this->kelompokUsias->firstWhere('id', $kelUsiaId);
                    if ($kelompokUsia) {
                        $minAge = $kelompokUsia->min_age;
                        $maxAge = $kelompokUsia->max_age;

                        // $tahunSekarang = now()->year;
                        // $tahunAkhir = $tahunSekarang - $minAge;
                        // $tahunAwal = $tahunSekarang - $maxAge;
                        // if ($kelompokUsia->max_age === null || $kelompokUsia->max_age === 0) {
                        //     $tahunAwal = 1900;
                        // }
                        // $q->orWhere(function ($sub) use ($tahunAwal, $tahunAkhir) {
                        //     $sub->whereYear('tgl_lahir', '>=', $tahunAwal)
                        //         ->whereYear('tgl_lahir', '<=', $tahunAkhir);
                        // });


                        $youngestBirthdate = $today->copy()->subYears($minAge);
                        if ($kelompokUsia->max_age === null || $kelompokUsia->max_age === 0) {
                            $oldestBirthdate = Carbon::parse('1900-01-01'); // Tahun sangat tua
                        } else {
                            $oldestBirthdate = $today->copy()->subYears($maxAge);
                        }
                        $q->orWhere(function ($sub) use ($oldestBirthdate, $youngestBirthdate) {

                            $sub->where('tgl_lahir', '>=', $oldestBirthdate->toDateString())
                                ->where('tgl_lahir', '<=', $youngestBirthdate->toDateString());
                        });
                    }
                }
            });
        }

        if ($this->searchTgl_babtis_awal) {
            $query->where('tgl_babtis', '>=', $this->searchTgl_babtis_awal);
        }
        if ($this->searchTgl_babtis_akhir) {
            $query->where('tgl_babtis', '<=', $this->searchTgl_babtis_akhir);
        }
        if ($this->searchTgl_sidi_awal) {
            $query->where('tgl_sidi', '>=', $this->searchTgl_sidi_awal);
        }
        if ($this->searchTgl_sidi_akhir) {
            $query->where('tgl_sidi', '<=', $this->searchTgl_sidi_akhir);
        }

        // Sorting
        if ($this->sortField1 === 'name') {
            $query->orderBy('name', $this->sortDirection1);
        }
        //         dd([
        //     'sql' => $query->toSql(),
        //     'bindings' => $query->getBindings(),
        // ]);
        // Trigger frontend reactivity
        $this->dispatch('reinit-hsselect');

        // Pagination
        return $query->paginate($this->perPage);
    }

    public function resetFilter()
    {
        $this->reset();
        $this->mount();
        $this->resetPage();
    }

    public function cariFilter()
    {
        $this->resetPage();
        // $this->render();
        // Flux::modal('filter')->close();
    }

    public function export(): BinaryFileResponse
    {
        return Excel::download(
            new AnggotaExport($this),
            'data-anggota.xlsx'
        );
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
