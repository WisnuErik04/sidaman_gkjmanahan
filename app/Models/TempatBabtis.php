<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TempatBabtis extends Model
{
    protected $table = 'tempat_babtises';
    protected $fillable = ['name'];

    public function keluarga(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'tempat_babtis_id');
    }
}
