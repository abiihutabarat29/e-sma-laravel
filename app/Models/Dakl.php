<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dakl extends Model
{
    use HasFactory;

    protected $table = "dakl";

    protected $fillable = [
        'sekolah_id', 'mapel_id', 'dibutuhkan', 'pns', 'nonpns', 'kurang', 'lebih', 'keterangan'
    ];

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
