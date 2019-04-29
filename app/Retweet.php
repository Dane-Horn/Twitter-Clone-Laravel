<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retweet extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function original(){
        return $this->belongsTo('App\Tweet', 'tweet_id');
    }

    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
