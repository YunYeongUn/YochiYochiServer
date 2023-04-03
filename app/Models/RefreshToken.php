<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'refresh_token'
    ];

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'user_id', 'id');
    }
}