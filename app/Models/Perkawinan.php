<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perkawinan extends Model
{
    protected $fillable = ['name'];

    public function keluargaAnggota(): HasMany
    {
        return $this->hasMany(KeluargaAnggota::class, 'perkawinan_id');
    }
}
