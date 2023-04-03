<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qna extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'qna_title',
        'qna_content',
        'writer',
        'attachment',
        'category'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
      
    ];

    public function users()
    {
        return $this->belongsTo('\App\Models\User', 'writer', 'id');
    }

    public function qnacategories()
    {
        return $this->belongsTo('\App\Models\Qnacategory', 'category','id');
    }
}