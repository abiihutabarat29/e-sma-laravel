<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = "sekolah";

    protected $fillable = [
        'kabupaten_id', 'npsn', 'jenjang', 'nama_sekolah', 'status'
    ];
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
    public function guru()
    {
        return $this->hasMany(Guru::class);
    }
}
