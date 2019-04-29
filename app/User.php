<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function setPasswordAttribute($password){
        if (!empty($password))
            $this->attributes['password'] = bcrypt($password);
    }

    public function tweets(){
        return $this->hasMany('App\Tweet', 'user_id');
    }

    public function retweets(){
        return $this->hasMany('App\Retweet', 'user_id');
    }

    public function followings(){
        return $this->hasMany('App\Following', 'user_id');
    }

    public function followees(){
        return $this->belongsToMany('App\User', 'followings', 'user_id', 'following_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
