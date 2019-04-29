<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    //
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = ['text'];

    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function replies(){
        return $this->hasMany('App\Tweet', 'references');
    }

    public function parent(){
        return $this->belongsTo('App\Tweet', 'references');
    }
}
