<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use App\Retweet;
use Uuid;
class RetweetController extends Controller
{
    public function create(Request $request, $id){
        try{
            $user = auth()->userorFail();
            $tweet = Tweet::findOrFail($id);
        }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([], 401);
        }
        $retweet = new Retweet();
        $retweet->user_id = $user->id;
        $retweet->tweet_id = $id;
        $retweet->id = Uuid::generate();
        $retweet->save();
        return response()->json($retweet->toArray());
    }

    public function destroy(Request $request, $id){
        try{
            $user = auth()->userOrFail();
            $retweet = Retweet::findOrFail($id);
            if ($user->id <> $retweet->user_id)
                throw new Exception('Blah');
        } catch (Exception $e){
            return response()->json([], 401);
        }
        $retweet->delete();
    }
}
