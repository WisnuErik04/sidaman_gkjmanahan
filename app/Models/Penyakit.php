<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyakit extends Model
{
    protected $fillable = ['name'];

    public function keluargaAnggota(): HasMany
    {
        return $this->hasMany(KeluargaAnggota::class, 'penyakit_id');
    }
}
