<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gameword extends Model
{
    use HasFactory;
    protected $table = "game_imgs";

    protected $primaryKey = 'id';

    protected $fillable = [
        'game_id',
        'word'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function games()
    {
        return $this->belongsTo('\App\Models\Game', 'game_id', 'id');
    }
}