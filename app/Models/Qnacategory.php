<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qnacategory extends Model
{
    use HasFactory;

    protected $table = "qnacategories";

    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
      
    ];

    public function qnas()
    {
        return $this->hasMany('\App\Models\Qna', 'category', 'id');
    }
}