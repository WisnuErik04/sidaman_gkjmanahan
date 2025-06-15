<?php

namespace App\Models;

use App\Models\Keluarga;
use Masmerise\Toaster\Toaster;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blok extends Model
{
    protected $fillable = ['name'];

    public function keluarga(): HasMany
    {
        return $this->hasMany(Keluarga::class, 'blok_id');
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'blok_id');
    }

}
