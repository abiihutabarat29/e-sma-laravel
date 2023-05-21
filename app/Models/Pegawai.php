<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = "pegawai";

    protected $fillable = [
        'sekolah_id', 'nip', 'nik', 'nuptk',  'nama', 'alamat',
        'tempat_lahir', 'tgl_lahir', 'gender', 'golongan',
        'tingkat', 'jurusan', 'thnijazah', 'agama', 'status', 'tmtpegawai',
        'tmtsekolah',   'mk_thn', 'mk_bln', 'nmdiklat', 'tdiklat', 'lmdiklat',
        'thndiklat', 'nohp', 'email', 'kehadiran', 'foto'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
