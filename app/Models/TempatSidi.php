<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempatSidi extends Model
{
    protected $fillable = ['name'];
    public function keluargaAnggota(): HasMany
    {
        return $this->hasMany(KeluargaAnggota::class, 'tempat_sidi_id');
    }
}
