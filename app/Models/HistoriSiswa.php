<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriSiswa extends Model
{
    use HasFactory;

    protected $table = "histori_siswa";

    protected $fillable = [
        'sekolah_id', 'siswa_id', 'kelas_id', 'tahun_ajaran_id', 'status'
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
