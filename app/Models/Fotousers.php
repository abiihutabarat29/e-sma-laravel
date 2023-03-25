<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotousers extends Model
{
    use HasFactory;
    protected $table = "fotousers";

    protected $fillable = [
        'user_id', 'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
