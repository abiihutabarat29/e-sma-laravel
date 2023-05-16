<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = "guru";

    protected $fillable = [
        'sekolah_id', 'nip', 'nik', 'nuptk', 'nrg', 'nama', 'alamat',
        'tempat_lahir', 'tgl_lahir', 'gender', 'golongan',
        'tingkat', 'jurusan', 'thnijazah', 'agama', 'status', 'tmtguru',
        'tmtsekolah', 'thnserti', 'mapel', 'j_jam', 'mk_thn', 'mk_bln',
        'tgs_tambah', 'sts_serti', 'mapel_serti', 'jabatan', 'no_sk', 'tgl_sk',
        'nmdiklat', 'tdiklat', 'lmdiklat', 'thndiklat', 'nohp', 'email', 'kehadiran', 'foto'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
