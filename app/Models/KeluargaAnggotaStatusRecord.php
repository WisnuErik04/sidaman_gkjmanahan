<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeluargaAnggotaStatusRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'keluarga_anggota_id',
        'status_anggota_id',
        'tanggal_status',
    ];

    protected $with = ['statusAnggota'];
    protected $casts = [
        'tanggal_input' => 'date',
    ];

    public function keluargaAnggota(): BelongsTo
    {
        return $this->belongsTo(KeluargaAnggota::class);
    }

    public function statusAnggota(): BelongsTo
    {
        return $this->belongsTo(StatusAnggota::class);
    }
}
