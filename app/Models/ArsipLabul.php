<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipLabul extends Model
{
    use HasFactory;

    protected $table = "arsip_labul";

    protected $fillable = [
        'sekolah_id', 'nama_labul', 'bulan', 'tahun', 'file_labul', 'validfile'
    ];
}
