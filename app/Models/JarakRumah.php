<?php

namespace App\Models;

use App\Models\Keluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JarakRumah extends Model
{
    protected $fillable = ['name'];

    public function keluarga(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'jarak_rumah_id');
    }
}
