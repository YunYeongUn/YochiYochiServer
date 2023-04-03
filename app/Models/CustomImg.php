<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomImg extends Model
{
    use HasFactory;

    protected $table = "custom_imgs";

    protected $primaryKey = 'id';

    protected $fillable = [
        
        'game_id',
        'imgpath',
        'user_id'
      
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

    public function users()
    {
        return $this->belongsTo('\App\Models\User', 'user_id', 'id');
    }
}