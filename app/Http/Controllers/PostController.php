<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class PostController extends Controller
{
    public function own(){
        try{
            $userId = auth()->userOrFail()->id;
        } catch (Exception $e){
            return response()->json([], 401);
        }
        $user = User::with(['tweets'=> function($query){
            $query->with('replies')->where('references', null);
        }, 'retweets'])->find($userId);
        return response()->json(['tweets' => $user->tweets, 'retweets' => $user->retweets]);
    }

    public function feed(){
        try{
            $userId = auth()->userOrFail()->id;
        } catch (Exception $e){
            return response()->json([], 401);
        }
        
        $followees = User::with(['followees' => function($query){
            $query->with(['tweets' => function($query){
                $query->with(['replies' => function($query){
                    $query->with('replies');
                }])->where('references', null);
            }, 'retweets']);
        }])->find($userId)->followees;

        $tweets = [];
        $retweets = [];
        foreach ($followees as $followee){
            $tweets = array_merge($tweets, $followee->tweets->toArray());
            $retweets = array_merge($retweets, $followee->retweets->toArray());
        }

        return response()->json(['tweets' => $tweets, 'retweets' => $retweets], 201);
    }
}
