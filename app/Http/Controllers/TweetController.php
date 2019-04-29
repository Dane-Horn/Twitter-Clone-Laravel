<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uuid;
use App\Tweet;
use Exception;

class TweetController extends Controller
{
    //
    public function create(Request $request){
        try{
            $user = auth()->userorFail();
        }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([], 401);
        }

        $tweet = new Tweet(['text' => $request->text]);
        $tweet->user_id = $user->id;
        $tweet->id = Uuid::generate();
        $tweet->save();
        return response()->json($tweet->toArray());
    }

    public function destroy(Request $request, $id){
        try{
            $user = auth()->userOrFail();
            $tweet = Tweet::findOrFail($id);
            if ($user->id <> $tweet->user_id)
                throw new Exception('Blah');
        } catch (Exception $e){
            return response()->json([], 401);
        }
        $tweet->delete();
        $tweet->replies()->delete();
    }

    public function reply(Request $request, $id){
        try{
            $user = auth()->userorFail();
            $parent = Tweet::findOrFail($id);
        }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([], 401);
        }

        $tweet = new Tweet(['text' => $request->text]);
        $tweet->user_id = $user->id;
        $tweet->id = Uuid::generate();
        $tweet->references = $id;
        $tweet->save();
        return response()->json($tweet->toArray());
    }
}
