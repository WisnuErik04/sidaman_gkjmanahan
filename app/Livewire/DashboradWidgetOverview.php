<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Attendance;
use App\Models\Keluarga;
use App\Models\KeluargaAnggota;

class DashboradWidgetOverview extends Component
{
    public $totalStudents;
    public $totalUsers;
    public $totalTeachers;
    public $presentToday;
    public $absentToday;
    public $weeklyAttendanceRate;
    public $monthlyTrends = [];
    public $attendanceToday;

    public $totalKeluargas;
    public $totalKeluargaAnggotas;
    public $totalJnsKelamin;
    public $generasiJemaat;
    public $kelompokUsia;


    public function mount()
    {

        // Fetch Data
        $this->totalKeluargas = Keluarga::whereNull('deleted_at')->count();

        $this->totalKeluargaAnggotas = KeluargaAnggota::whereNull('deleted_at')
            // ->where('is_wafat', '0')
            ->whereIn('status_anggota_id', ['1', '3', '4'])
            ->count();

        // Total keluarga
        $totalKeluargaQuery = Keluarga::whereNull('deleted_at');
        if (auth()->user()->role === 'majelis') {
            $totalKeluargaQuery->where('blok_id', auth()->user()->blok_id);
        } elseif (auth()->user()->role === 'warga') {
            $keluarga_id = KeluargaAnggota::where('user_id', auth()->user()->id)->pluck('keluarga_id');
            $totalKeluargaQuery->where('id', $keluarga_id[0]);
        }
        $this->totalKeluargas = $totalKeluargaQuery->count();


        // Total anggota keluarga (yang belum wafat)
        $totalAnggotaQuery = KeluargaAnggota::whereNull('deleted_at')
            // ->where('is_wafat', '0')
            ->whereIn('status_anggota_id', ['1', '3', '4']);
        if (auth()->user()->role === 'majelis') {
            $totalAnggotaQuery->whereHas('keluarga', function ($q) {
                $q->where('blok_id', auth()->user()->blok_id);
            });
        } elseif (auth()->user()->role === 'warga') {
            $keluarga_id = KeluargaAnggota::where('user_id', auth()->user()->id)->pluck('keluarga_id');
            $totalAnggotaQuery->where('keluarga_id', $keluarga_id[0]);
        }
        $this->totalKeluargaAnggotas = $totalAnggotaQuery->count();

        // $this->totalJnsKelamin = KeluargaAnggota::selectRaw('jns_kelamin, COUNT(*) as total')
        //     ->whereNull('deleted_at')
        //     ->where('is_wafat', '0')
        //     ->groupBy('jns_kelamin')
        //     ->pluck('total', 'jns_kelamin')
        //     ->mapWithKeys(function ($val, $key) {
        //         return [$key === 'L' ? 'Laki-laki' : 'Perempuan' => $val];
        //     });

        $query = KeluargaAnggota::selectRaw('jns_kelamin, COUNT(*) as total')
            ->whereNull('deleted_at')
            ->whereIn('status_anggota_id', ['1', '3', '4'])
            // ->where('is_wafat', '0')
            ;
        // Filter khusus jika user adalah majelis
        if (auth()->user()->role === 'majelis') {
            $query->whereHas('keluarga', function ($q) {
                $q->where('blok_id', auth()->user()->blok_id);
            });
        }
        $this->totalJnsKelamin = $query->groupBy('jns_kelamin')
            ->pluck('total', 'jns_kelamin')
            ->mapWithKeys(function ($val, $key) {
                return [$key === 'L' ? 'Laki-laki' : 'Perempuan' => $val];
            });

        $ranges = [
            '<1946' => 1945,
            'Baby Boomers (1946 - 1964)' => 1964,
            'Gen X (1965 - 1980)' => 1980,
            'Gen Y (1981 - 1994)' => 1994,
            'Gen Z (1995 - 2010)' => 2010,
            'Gen Alpha (2011 - sekarang)' => 2050,
        ];
       

        $rangesKelompokUsias = [
            'Anak - anak (0 - 12 Tahun)' => 12,
            'Pra Remaja (13 - 17 Tahun)' => 17,
            'Remaja (18 - 25 Tahun)' => 25, 
            'Dewasa (26 - 60 Tahun)' => 60,
            // 'Remaja (13 - 17 Tahun)' => 17,
            // 'Pemuda (18 - 30 Tahun)' => 30,
            // 'Dewasa (31 - 60 Tahun)' => 60,
            // 'Lansia (> 60 Tahun)' => 150,
        ];
          

        $query = KeluargaAnggota::select("tgl_lahir")
            ->whereNotNull("tgl_lahir")
            ->whereNull('deleted_at')
            ->whereIn('status_anggota_id', ['1', '3', '4']); // status

        // Filter jika user adalah majelis
        if (auth()->user()->role === 'majelis') {
            $query->whereHas('keluarga', function ($q) {
                $q->where('blok_id', auth()->user()->blok_id);
            });
        }

        $this->generasiJemaat = $query->get()
            ->map(function ($anggota) use ($ranges) {
                $year = Carbon::parse($anggota->tgl_lahir)->year;
                foreach ($ranges as $key => $breakpoint) {
                    if ($year <= $breakpoint) {
                        $anggota->range = $key;
                        break;
                    }
                }
                return $anggota;
            })
            ->mapToGroups(function ($anggota) {
                return [$anggota->range => $anggota];
            })
            ->map(fn($group) => count($group));

        $this->kelompokUsia = $query->get()
        ->map(function ($anggota) use ($rangesKelompokUsias) {
                $tanggalLahir = Carbon::parse($anggota->tgl_lahir);
                $usia = $tanggalLahir->diffInYears(Carbon::now()); // Menghitung perbedaan tahun (usia)
                foreach ($rangesKelompokUsias as $key => $breakpoint) {
                    if ($usia <= $breakpoint) {
                        $anggota->range = $key;
                        break;
                    }
                }
                if (!isset($anggota->range)) {
                    $anggota->range = 'Lansia (> 60 Tahun)'; 
                }
                return $anggota;
            })
            ->mapToGroups(function ($anggota) {
                return [$anggota->range => $anggota];
            })
            ->map(fn($group) => count($group));
    }
    public function render()
    {
        return view('livewire.dashborad-widget-overview');
    }
}
