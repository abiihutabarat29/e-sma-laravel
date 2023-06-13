<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisSekolah extends Model
{
    use HasFactory;

    protected $table = "inventaris_sekolah";

    protected $fillable = [
        'sekolah_id', 'inventaris_id', 'dibutuhkan', 'ada', 'kurang', 'lebih'
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
