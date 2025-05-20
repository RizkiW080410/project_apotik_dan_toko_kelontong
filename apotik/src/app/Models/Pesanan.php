<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'pesanans';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'menunggu_pembayaran' => 'Menunggu Konfirmasi',
        'diproses' => 'Pesanan Diproses',
        'diantar' => 'Pesanan Diantar',
        'selesai' => 'Selesai',
    ];

    protected $fillable = [
        'profile_id',
        'nomor_pesanan',
        'total',
        'status',
        'pengajuan_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Relasi ke Profile
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    // Relasi ke Pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    // Relasi ke Item Pesanan
    public function items()
    {
        return $this->hasMany(PesananItem::class);
    }

    // Relasi ke Pengiriman (jika satu pesanan hanya punya satu pengiriman)
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class);
    }
}
