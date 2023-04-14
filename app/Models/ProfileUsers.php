<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUsers extends Model
{
    use HasFactory;

    protected $table = "profile_users";

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'nik',
        'tempat_lahir',
        'tgl_lahir',
        'gender',
        'nohp',
        'alamat',
        'foto',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
