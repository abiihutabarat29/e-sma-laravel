<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarpras extends Model
{
    use HasFactory;

    protected $table = "sarpras";

    protected $fillable = [
        'sekolah_id', 'sarana_id', 'baik', 'rusak_ringan', 'rusak_berat', 'keterangan'
    ];
    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}
