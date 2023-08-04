<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Roman;

class TahunAjaran extends Model
{
    use HasFactory;


    protected $table = 'tahun_ajaran';
    protected $fillable = ['nama', 'status'];

    public function rombel()
    {
        return $this->hasMany(Rombel::class, 'tahun_ajaran_id');
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'tahun_ajaran_id');
    }
}
