<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function followee(){
        return $this->belongsTo('App\User', 'following_id');
    }
}
