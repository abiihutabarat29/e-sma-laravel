<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bangunan extends Model
{
    use HasFactory;

    protected $table = "bangunan";

    protected $fillable = [
        'sekolah_id', 'luas_tanah', 'luas_bangunan', 'luas_rpembangunan',
        'luas_halaman', 'luas_lapangan', 'luas_kosong', 'status_tanah', 'status_gedung'
    ];
}
