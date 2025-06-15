<?php

namespace App\Models;

use App\Models\KeluargaAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HubunganKeluarga extends Model
{
    protected $fillable = ['name'];

    public function keluargaAnggota(): HasMany
    {
        return $this->hasMany(KeluargaAnggota::class, 'hubungan_keluarga_id');
    }
}
