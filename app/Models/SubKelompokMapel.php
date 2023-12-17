<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKelompokMapel extends Model
{
    use HasFactory;

    protected $table = "subkelompok_mapel";
    protected $fillable = [
        'kelompok_id', 'kode', 'nama_subkelompok'
    ];

    public function kelompok()
    {
        return $this->belongsTo(KelompokMapel::class);
    }
}
