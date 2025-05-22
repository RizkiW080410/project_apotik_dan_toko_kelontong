<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nomor_telepon',
        'jenis_kelamin',
        'tanggal_lahir',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
