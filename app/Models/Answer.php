<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'comment',
        'qna_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function qna()
    {
        return $this->belongsTo('\App\Models\Qna', 'qna_id','id');
    }
}