<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = "sekolah";

    protected $fillable = [
        'npsn', 'jenjang', 'nama_sekolah', 'status', 'kabupaten'
    ];
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
