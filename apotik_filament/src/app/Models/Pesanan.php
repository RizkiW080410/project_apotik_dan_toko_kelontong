<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'nomor_pesanan',
        'tanggal',
        'total',
        'status',
        'pengajuan_id',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function items()
    {
        return $this->hasMany(PesananItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pesanan) {
            // Nomor pesanan otomatis
            if (empty($pesanan->nomor_pesanan)) {
                $lastId = self::max('id') ?? 0;
                $nextId = $lastId + 1;
                $pesanan->nomor_pesanan = 'PSN-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
            }
        });

        static::saving(function ($pesanan) {
            // Hitung total dari item
            $total = 0;
            if ($pesanan->items) {
                foreach ($pesanan->items as $item) {
                    $total += $item->total ?? 0;
                }
            }
            $pesanan->total = $total;
        });
    }

    protected $with = ['items'];
}
