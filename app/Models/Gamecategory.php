<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gamecategory extends Model
{
    use HasFactory;
    protected $table = "gamecategories";

    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
      
    ];

    public function games()
    {
        return $this->hasMany('\App\Models\Game', 'category', 'id');
    }
}