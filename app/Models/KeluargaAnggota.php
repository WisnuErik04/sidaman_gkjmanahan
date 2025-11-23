<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KeluargaAnggota extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
                'keluarga_id',
                'user_id',
                'name',
                'jns_kelamin',
                'nomor_induk_gereja',
                'hubungan_keluarga_id',
                'perkawinan_id',
                'tgl_lahir',
                'gol_darah_id',
                'ijazah_id',
                'pekerjaan_id',
                'pendapatan_id',
                'tempat_babtis_id',
                'tgl_babtis',
                'tempat_sidi_id',
                'tgl_sidi',
                'hobi_id',
                'aktifitas_pelayanan',
                'memiliki_bpjs_asuransi',
                'penyakit_id',
                'domisili_alamat',
                'nomor_wa',
                'is_wafat',
                'tgl_wafat',
                'status_anggota_id',
    ];
    
    protected $with = [
        'keluarga',
        'user',
        'hubunganKeluarga',
        'perkawinan',
        'golDarah',
        'ijazah',
        'pekerjaan',
        'pendapatan',
        'tempatBabtis',
        'tempatSidi',
        'hobi',
        'penyakit',
        'recordPenyakit',
        'recordHobi',
        'status',
    ];

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function hubunganKeluarga(): BelongsTo
    {
        return $this->belongsTo(HubunganKeluarga::class);
    }
    public function perkawinan(): BelongsTo
    {
        return $this->belongsTo(Perkawinan::class);
    }
    public function golDarah(): BelongsTo
    {
        return $this->belongsTo(GolDarah::class);
    }
    public function ijazah(): BelongsTo
    {
        return $this->belongsTo(Ijazah::class);
    }
    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class);
    }
    public function pendapatan(): BelongsTo
    {
        return $this->belongsTo(Pendapatan::class);
    }
    public function tempatBabtis(): BelongsTo
    {
        return $this->belongsTo(TempatBabtis::class);
    }
    public function tempatSidi(): BelongsTo
    {
        return $this->belongsTo(TempatSidi::class);
    }
    public function hobi(): BelongsTo
    {
        return $this->belongsTo(Hobi::class);
    }
    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class);
    }
    public function recordPenyakit(): BelongsToMany
    {
        return $this->belongsToMany(Penyakit::class, 'keluarga_anggota_penyakits', 'keluarga_anggota_id', 'penyakit_id');
    }
    public function recordHobi(): BelongsToMany
    {
        return $this->belongsToMany(Hobi::class, 'keluarga_anggota_hobis', 'keluarga_anggota_id', 'hobi_id');
    }
    public function status(): BelongsTo
    {
        // return $this->belongsTo(StatusAnggota::class);
        return $this->belongsTo(StatusAnggota::class, 'status_anggota_id');
    }
}
