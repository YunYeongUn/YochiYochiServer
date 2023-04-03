<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticecategory extends Model
{
    use HasFactory;

    protected $table = "noticecategories";

    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
      
    ];

    public function notices()
    {
        return $this->hasMany('\App\Models\Notice', 'category', 'id');
    }
}