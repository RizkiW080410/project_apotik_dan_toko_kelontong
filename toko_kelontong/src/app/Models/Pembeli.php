<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembeli extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nama_lengkap', 'jenis_kelamin', 'nomor_telpon', 'avatar'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function alamats(): HasMany
    {
        return $this->hasMany(Alamat::class);
    }

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }
}
