<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengirim extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jenis_kelamin', 'nomor_telepon', 'email', 'jenis_kendaraan'];

    public function pengirimans(): HasMany
    {
        return $this->hasMany(Pengiriman::class);
    }
}
