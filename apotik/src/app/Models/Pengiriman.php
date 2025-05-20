<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengiriman extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'pengirimen';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'menunggu' => 'Menunggu Konfirmasi',
        'diantar' => 'Diantar',
        'selesai' => 'Selesai',
    ];

    protected $fillable = [
        'pesanan_id',
        'pengirim_id',
        'alamat',
        'jarak',
        'total',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    // Relasi ke Pengirim
    public function pengirim()
    {
        return $this->belongsTo(Pengirim::class);
    }
}
