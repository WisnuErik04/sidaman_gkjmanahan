<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempatSidi extends Model
{
    protected $fillable = ['name'];
    public function keluarga(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'tempat_sidi_id');
    }
}
