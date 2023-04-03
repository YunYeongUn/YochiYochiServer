<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemcategory extends Model
{
    use HasFactory;
    protected $table = "itemcategories";

    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
      
    ];

    public function items()
    {
        return $this->hasMany('\App\Models\Item', 'category', 'id');
    }
}