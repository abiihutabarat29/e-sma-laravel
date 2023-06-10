<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSekolah extends Model
{
    use HasFactory;

    protected $table = "profile_sekolah";

    protected $fillable = [
        'sekolah_id', 'kabupaten_id', 'kecamatan_id', 'desa_id', 'nss', 'nds', 'nosiop', 'akreditas',
        'thnberdiri', 'nosk', 'tglsk', 'standar', 'waktub', 'alamat', 'kodepos', 'telp', 'email',
        'website',  'nip', 'kepsek', 'foto_kepsek', 'namayss', 'alamatyss', 'gmap', 'foto_sekolah'
    ];
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
