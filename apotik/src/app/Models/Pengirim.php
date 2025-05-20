<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengirim extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'pengirims';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const JENIS_KELAMIN_SELECT = [
        'laki-laki' => 'Laki-Laki',
        'perempuan' => 'Perempuan',
    ];

    protected $fillable = [
        'name',
        'nomor_telepon',
        'email',
        'jenis_kelamin',
        'jenis_kendaraan',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Relasi ke tabel pengirimen
    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class);
    }
}
