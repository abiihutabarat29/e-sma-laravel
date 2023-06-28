<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateLabul extends Model
{
    use HasFactory;

    protected $table = "generate_labul";

    protected $fillable = [
        'sekolah_id', 'nama_labul'
    ];
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
