<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $primaryKey = 'id';

    protected $fillable = [
        'post_title',
        'post_content',
        'writer',
        'attachment'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'views'
    ];

    public function users()
    {
        return $this->belongsTo('\App\Models\User', 'writer', 'id');
    }

    public function comments()
    {
        return $this->hasMany('\App\Models\Comment', 'post_id','id');
    }
}