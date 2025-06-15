<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perkawinan extends Model
{
    protected $fillable = ['name'];

    public function keluarga(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'perkawinan_id');
    }
}
