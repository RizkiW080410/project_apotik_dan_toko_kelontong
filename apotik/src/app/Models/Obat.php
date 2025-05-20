<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Obat extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $table = 'obats';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'habis' => 'Habis',
        'tersedia' => 'Tersedia',
    ];

    public const STATUS_LABEL_SELECT = [
        'tanpa_resep' => 'Tanpa Resep',
        'dengan_resep' => 'Dengan Resep',
    ];

    protected $fillable = [
        'jenis_id',
        'golongan_id',
        'kode_obat',
        'nama_obat',
        'komposisi',
        'dosis',
        'aturan_pakai',
        'nomor_izin_edaar',
        'tanggal_kadaluarsa',
        'harga',
        'stok',
        'status_label',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }
        return $file;
    }

    // Relasi
    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
