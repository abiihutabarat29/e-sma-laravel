<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = "siswa";

    protected $fillable = [
        'sekolah_id', 'nisn', 'nama', 'alamat',
        'tempat_lahir', 'tgl_lahir', 'gender', 'agama',
        'kelas_id', 'pkeahlian', 'nohp', 'email', 'program_pip',
        'tahun_masuk', 'asal_sekolah', 'no_surat', 'sts_siswa', 'keterangan', 'foto'
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
