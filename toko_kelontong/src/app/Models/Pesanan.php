<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = ['pembeli_id', 'nomor_pesanan', 'total','status', 'payment_type',
    'transaction_status',
    'fraud_status',
    'bank',
    'va_number',];

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PesananItem::class);
    }

    public function pengiriman(): HasOne
    {
        return $this->hasOne(Pengiriman::class);
    }

    protected static function booted()
    {
        // Generate nomor_pesanan saat create
        static::creating(function ($pesanan) {
            $lastPesanan = self::orderBy('id', 'desc')->first();
            $lastNumber = $lastPesanan ? intval(substr($lastPesanan->nomor_pesanan, 2)) : 0;
            $pesanan->nomor_pesanan = 'P-' . str_pad($lastNumber + 1, 8, '0', STR_PAD_LEFT);
        });

        static::updated(function ($pesanan) {
            $pesanan->recalculateTotal();
        });

        // Kurangi stok saat status menjadi diproses
        static::updating(function ($pesanan) {
            if (
                $pesanan->isDirty('status') &&
                $pesanan->status === 'diproses' &&
                $pesanan->getOriginal('status') !== 'diproses'
            ) {
                foreach ($pesanan->items as $item) {
                    $product = $item->product;

                    if ($product && $product->stok >= $item->qty) {
                        $product->decrement('stok', $item->qty);
                    } else {
                        throw new \Exception("Stok produk '{$product->name}' tidak cukup.");
                    }
                }
            }
        });
    }

    public function recalculateTotal(): void
    {
        // Sum total semua items
        $total = $this->items()->sum('total');

        // Cek agar tidak terus-menerus update
        if ($this->total !== $total) {
            $this->total = $total;
            $this->saveQuietly(); // Hindari infinite loop event
        }
    }
}
