<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    protected $table = "rombel";

    protected $fillable = [
        'sekolah_id', 'kelas', 'jurusan', 'ruangan', 'tahun_ajaran_id'
    ];
    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
