<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tel',
        'address',
        'kidgender',
        'kidname',
        'kidBirth'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany('\App\Models\Post', 'writer', 'id');
    }

    public function comments()
    {
        return $this->hasMany('\App\Models\Comment', 'writer', 'id');
    }

    public function Scoreboards()
    {
        return $this->hasMany('\App\Models\Scoreboard', 'user_id', 'id');
    }

    public function customimgs()
    {
        return $this->hasMany('\App\Models\CustomImg', 'user_id', 'id');
    }

    public function customwords()
    {
        return $this->hasMany('\App\Models\CustomWord', 'user_id', 'id');
    }

    public function qnas()
    {
        return $this->hasMany('\App\Models\Qna', 'writer', 'id');
    }

    public function itemreviews()
    {
        return $this->hasMany('\App\Models\Itemreview', 'writer', 'id');
    }

    public function RefreshTokens(){
        return $this->hasMany('\App\Models\RefreshToken', 'user_id', 'id');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}