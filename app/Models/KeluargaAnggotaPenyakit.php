<?php

namespace App\Models;

use App\Models\KeluargaAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KeluargaAnggotaPenyakit extends Model
{
    protected $fillable = ['keluarga_anggota_id','penyakit_id'];

    public function keluargaAnggota(): HasMany
    {
        return $this->hasMany(KeluargaAnggota::class, 'id');
    }
}
