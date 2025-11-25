<?php

namespace App\Exports;

use Illuminate\Support\Carbon;
use App\Models\KeluargaAnggota;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class AnggotaExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = KeluargaAnggota::query();

        // Terapkan semua filter dari komponen Livewire
        if (auth()->user()->role == 'majelis') {
            $query->whereRelation('keluarga', 'blok_id', auth()->user()->blok_id)->get();
        }
        if ($this->filters->searchName) {
            $query->where('name', 'like', '%' . $this->filters->searchName . '%');
        }
        if ($this->filters->searchNIG) {
            $query->where('nomor_induk_gereja', 'like', '%' . $this->filters->searchNIG . '%');
        }

        if ($this->filters->searchHubunganKeluarga) {
            $query->whereIn('hubungan_keluarga_id', $this->filters->searchHubunganKeluarga);
        }
        if ($this->filters->searchPerkawinan) {
            $query->whereIn('perkawinan_id', $this->filters->searchPerkawinan);
        }
        if ($this->filters->searchGolDarah) {
            $query->whereIn('gol_darah_id', $this->filters->searchGolDarah);
        }
        if ($this->filters->searchIjazah) {
            $query->whereIn('ijazah_id', $this->filters->searchIjazah);
        }
        if ($this->filters->searchPekerjaan) {
            $query->whereIn('pekerjaan_id', $this->filters->searchPekerjaan);
        }
        if ($this->filters->searchPendapatan) {
            $query->whereIn('pendapatan_id', $this->filters->searchPendapatan);
        }
        if ($this->filters->searchTempatBabtis) {
            $query->whereIn('tempat_babtis_id', $this->filters->searchTempatBabtis);
        }
        if ($this->filters->searchTempatSidi) {
            $query->whereIn('tempat_sidi_id', $this->filters->searchTempatSidi);
        }
        // if ($this->filters->searchHobi) {
        //     $query->whereIn('hobi_id', $this->filters->searchHobi);
        // }
        // if ($this->filters->searchPenyakit) {
        //     $query->whereIn('penyakit_id', $this->filters->searchPenyakit);
        // }
        if ($this->filters->searchHobi) {
            $hobiIds = $this->filters->searchHobi;
            $query->whereHas('recordHobi', function ($hobiQuery) use ($hobiIds) {
                $hobiQuery->whereIn('hobi_id', $hobiIds);
            });
        }
        if ($this->filters->searchPenyakit) {
            $penyakitIds = $this->filters->searchPenyakit;
            $query->whereHas('recordPenyakit', function ($penyakitQuery) use ($penyakitIds) {
                $penyakitQuery->whereIn('penyakit_id', $penyakitIds);
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->filters->searchKeluarga) {
            $query->where(function ($q) {
                $q->orWhereRelation('keluarga', 'name', 'like', '%' . $this->filters->searchKeluarga . '%')
                    ->orWhereHas('keluarga.blok', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->filters->searchKeluarga . '%');
                    });
            });
        }

        // Filter berdasarkan alamat dan relasi wilayah
        if ($this->filters->searchTgl_lahir_awal) {
            $query->where('tgl_lahir', '>=', $this->filters->searchTgl_lahir_awal);
        }
        if ($this->filters->searchTgl_lahir_akhir) {
            $query->where('tgl_lahir', '<=', $this->filters->searchTgl_lahir_akhir);
        }

        if ($this->filters->searchBlok) {
            $query->whereHas('keluarga.blok', function ($q) {
                $q->whereIn('id', $this->filters->searchBlok);
            });
        }

        if ($this->filters->searchTgl_ulang_tahun_awal && $this->filters->searchTgl_ulang_tahun_akhir) {
            $awal = date('m-d', strtotime($this->filters->searchTgl_ulang_tahun_awal));
            $akhir = date('m-d', strtotime($this->filters->searchTgl_ulang_tahun_akhir));

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

        if ($this->filters->searchGenerasi) {
            $query->where(function ($q) {
                foreach ($this->filters->searchGenerasi as $genId) {
                    $generasi = $this->filters->generasis->firstWhere('id', $genId);
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

        if ($this->filters->searchKelompokUsia) {
            $today = now();
            $query->where(function ($q) use ($today) {
                foreach ($this->filters->searchKelompokUsia as $kelUsiaId) {
                    $kelompokUsia = $this->filters->kelompokUsias->firstWhere('id', $kelUsiaId);
                    if ($kelompokUsia) {
                        $minAge = $kelompokUsia->min_age;
                        $maxAge = $kelompokUsia->max_age;

                        $tahunSekarang = now()->year;
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

        if ($this->filters->searchTgl_babtis_awal) {
            $query->where('tgl_babtis', '>=', $this->filters->searchTgl_babtis_awal);
        }
        if ($this->filters->searchTgl_babtis_akhir) {
            $query->where('tgl_babtis', '<=', $this->filters->searchTgl_babtis_akhir);
        }
        if ($this->filters->searchTgl_sidi_awal) {
            $query->where('tgl_sidi', '>=', $this->filters->searchTgl_sidi_awal);
        }
        if ($this->filters->searchTgl_sidi_akhir) {
            $query->where('tgl_sidi', '<=', $this->filters->searchTgl_sidi_akhir);
        }
        if ($this->filters->searchStatus) {
            $query->whereIn('status_anggota_id', $this->filters->searchStatus);
        }
        // Sorting
        if ($this->filters->sortField1 === 'name') {
            $query->orderBy('name', $this->filters->sortDirection1);
        }

        return $query->get()->map(function ($item) {
            return [
                'Keluarga' => $item->keluarga?->name ?? '-',
                'Blok' => $item->keluarga?->blok?->name ?? '-',
                'Nama anggota keluarga' => $item->name,
                'Jenis kelamin' => ($item->jns_kelamin == 'L') ? 'Laki - laki' : 'Perempuan',
                'Nomor Induk Gereja' => $item->nomor_induk_gereja,
                'Hubungan keluarga' => $item->hubunganKeluarga?->name ?? '-',
                'Status perkawinan' => $item->perkawinan?->name ?? '-',
                // 'Tanggal lahir' => $item->tgl_lahir,
                'Tanggal lahir' => \Carbon\Carbon::parse($item->tgl_lahir)->format('d-m-Y') ?? '',
                'Golongan darah' => $item->golDarah?->name ?? '-',
                'Ijasah terakhir' => $item->ijazah?->name ?? '-',
                'Kegiatan/ Pekerjaan' => $item->pekerjaan?->name ?? '-',
                'RPendapatan per bulan' => $item->pendapatan?->name ?? '-',
                'Tempat baptis anak' => $item->tempatBabtis?->name ?? '-',
                // 'Tanggal baptis anak' => $item->tgl_babtis,
                // 'Tanggal baptis anak' => \Carbon\Carbon::parse($item->tgl_babtis)->format('d-m-Y') ?? '',
                'Tanggal baptis anak' => $item->tgl_babtis ? \Carbon\Carbon::parse($item->tgl_babtis)->format('d-m-Y') : '-',
                'Tempat baptis dewasa/ Sidi' => $item->tempatSidi?->name ?? '-',
                // 'Tanggal baptis dewasa/ Sidi' => $item->tgl_sidi,
                // 'Tanggal baptis dewasa' => \Carbon\Carbon::parse($item->tgl_sidi)->format('d-m-Y') ?? '',
                'Tanggal baptis dewasa' => $item->tgl_sidi ? \Carbon\Carbon::parse($item->tgl_sidi)->format('d-m-Y') : '-',
                // 'Talenta/ Hobi' => $item->hobi?->name ?? '-',
                'Talenta/ Hobi' => $item->recordHobi->pluck('name')->implode(', ') ?? '-',
                'Aktivitas pelayanan yg aktif diikuti' => $item->aktifitas_pelayanan,
                'Memiliki bpjs atau asuransi lainnya' => ($item->memiliki_bpjs_asuransi == '1') ? 'Ya' : 'Tidak',
                // 'Apakah mempunyai penyakit kronis' => $item->penyakit?->name ?? '-',
                'Apakah mempunyai penyakit kronis' => $item->recordPenyakit->pluck('name')->implode(', ') ?? '-',
                'Domisili di alamat ini' => ($item->domisili_alamat == '1') ? 'Ya' : 'Tidak',
                'Nomor WA' => $item->nomor_wa,
                'Status' => $item->status?->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Keluarga',
            'Blok',
            'Nama anggota keluarga',
            'Jenis kelamin',
            'Nomor Induk Gereja',
            'Hubungan keluarga',
            'Status perkawinan',
            'Tanggal lahir',
            'Golongan darah',
            'Ijasah terakhir',
            'Kegiatan/ Pekerjaan',
            'Pendapatan per bulan',
            'Tempat baptis anak',
            'Tanggal baptis anak',
            'Tempat baptis dewasa/ Sidi',
            'Tanggal baptis dewasa/ Sidi',
            'Talenta/ Hobi',
            'Aktivitas pelayanan yg aktif diikuti',
            'Memiliki bpjs atau asuransi lainnya',
            'Apakah mempunyai penyakit kronis',
            'Domisili di alamat ini',
            'Nomor WA',
            'Status',
            // 'Kelompok Usia',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 10,
            'D' => 10,
            'E' => 10,
            'F' => 10,
            'G' => 10,
            'H' => 10,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'L' => 10,
            'M' => 10,
            'N' => 10,
            'O' => 10,
            'P' => 10,
            'Q' => 10,
            'R' => 10,
            'S' => 10,
            'T' => 10,
            'U' => 10,
            'V' => 10,
            'W' => 10,
        ];
    }
}
