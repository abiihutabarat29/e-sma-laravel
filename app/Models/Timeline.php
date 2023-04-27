<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $table = "timeline";

    protected $fillable = [
        'user_id', 'sekolah_id', 'status', 'pesan', 'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
