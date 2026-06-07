<?php

namespace App\Models;

use App\Models\KeluargaAnggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusAnggota extends Model
{
    protected $fillable = ['name'];

    public function statusRecords(): HasMany
    {
        return $this->hasMany(KeluargaAnggotaStatusRecord::class);
    }
}
