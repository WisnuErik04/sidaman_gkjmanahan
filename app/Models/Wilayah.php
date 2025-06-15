<?php

namespace App\Models;

use App\Models\Keluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wilayah extends Model
{
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode', 'nama'];

    public function keluargasDesaKelurahan(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'alamat_desa_kelurahan', 'kode');
    }

    public function keluargasKecamatan(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'alamat_kecamatan', 'kode');
    }

    public function keluargasKabKota(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'alamat_kab_kota', 'kode');
    }

    public function keluargasProvinsi(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'alamat_provinsi', 'kode');
    }
}
