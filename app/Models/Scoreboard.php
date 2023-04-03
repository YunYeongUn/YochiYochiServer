<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scoreboard extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'game_id',
        'score',
      
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsTo('\App\Models\User', 'user_id', 'id');
    }

    public function games()
    {
        return $this->belongsTo('\App\Models\Game', 'game_id', 'id');
    }
}