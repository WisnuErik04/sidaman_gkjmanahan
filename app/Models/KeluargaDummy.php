<?php

namespace App\Models;

use App\Models\Blok;
use App\Models\Wilayah;
use App\Models\JarakRumah;
use App\Models\KeluargaAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeluargaDummy extends Model
{
    protected $fillable = ['blok_id', 'name', 'alamat_detail', 'alamat_rt', 'alamat_rw', 'alamat_desa_kelurahan', 'alamat_kecamatan', 'alamat_kab_kota', 'alamat_provinsi', 'jarak_rumah_id'
            , 'keluarga_id', 'user_id_input'];
    protected $with = ['desaKelurahan', 'kecamatan', 'kabKota', 'provinsi', 'jarakRumah', 'blok'];

    public function keluargaAnggota(): HasMany
    {
        // return $this->hasMany(KeluargaAnggota::class, 'keluarga_id')->orderBy('order', 'asc');
        return $this->hasMany(KeluargaAnggota::class, 'keluarga_id');
    }

     public function desaKelurahan(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'alamat_desa_kelurahan', 'kode');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'alamat_kecamatan', 'kode');
    }

    public function kabKota(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'alamat_kab_kota', 'kode');
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'alamat_provinsi', 'kode');
    }

    public function jarakRumah(): BelongsTo
    {
        return $this->belongsTo(JarakRumah::class);
    }

    public function blok(): BelongsTo
    {
        return $this->belongsTo(Blok::class);
    }
}
