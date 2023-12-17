<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMapel extends Model
{
    use HasFactory;

    protected $table = "kelompok_mapel";
    protected $fillable = [
        'kategori_id', 'kode', 'nama_kelompok'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMapel::class);
    }
}
