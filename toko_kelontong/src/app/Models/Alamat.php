<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alamat extends Model
{
    use HasFactory;

    protected $fillable = ['nama_lengkap', 'nomor_telepon', 'lokasi', 'detail_alamat', 'label', 'pembeli_id'];

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pembeli::class);
    }
}
