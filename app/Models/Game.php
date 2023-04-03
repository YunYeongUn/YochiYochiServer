<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'category'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function scoreboards()
    {
        return $this->hasMany('\App\Models\Scoreboard', 'game_id', 'id');
    }

    public function gameimgs()
    {
        return $this->hasMany('\App\Models\Gameimg', 'game_id', 'id');
    }

    public function gamewords()
    {
        return $this->hasMany('\App\Models\Gamewords', 'game_id', 'id');
    }

    public function gamecategories()
    {
        return $this->belongsTo('\App\Models\Gamecategory', 'category','id');
    }
}