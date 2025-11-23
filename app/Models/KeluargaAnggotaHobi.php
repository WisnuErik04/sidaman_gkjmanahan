<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KeluargaAnggotaHobi extends Model
{
    protected $fillable = ['keluarga_anggota_id','hobi_id'];

    public function keluargaAnggota(): HasMany
    {
        return $this->hasMany(KeluargaAnggota::class, 'id');
    }
}
