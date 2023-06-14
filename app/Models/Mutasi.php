<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;

    protected $table = "mutasi";

    protected $fillable = [
        'sekolah_id', 'nisn', 'nama', 'alamat',
        'tempat_lahir', 'tgl_lahir', 'gender', 'agama',
        'kelas_id', 'pkeahlian', 'tahun_masuk', 'nohp', 'email',
        'asal_sekolah', 'no_surat', 'keterangan', 'sts_mutasi',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Rombel::class);
    }
}
