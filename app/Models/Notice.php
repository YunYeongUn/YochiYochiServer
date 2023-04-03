<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;
    

    protected $primaryKey = 'id';

    protected $fillable = [
        'notice_title',
        'notice_content',
        'attachment',
        'category'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
      
    ];

    public function noticecategories()
    {
        return $this->belongsTo('\App\Models\NoticeCategory', 'category','id');
    }
}