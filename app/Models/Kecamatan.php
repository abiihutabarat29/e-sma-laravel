<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = "kecamatan";

    protected $fillable = [
        'kabupaten_id', 'kode_wilayah', 'kecamatan'
    ];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
    public function desa()
    {
        return $this->hasMany(Desa::class);
    }
}
