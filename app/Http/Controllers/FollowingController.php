<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Following;
class FollowingController extends Controller
{
    public function follow($id){
        try{
            $user = auth()->userOrFail();
            $followee = User::findOrFail($id); 
        } catch (Exception $e){
            return response()->json([], 401);
        }
        $following = new Following();
        $following->user_id = $user->id;
        $following->following_id = $id;
        $following->save();
    }

    public function getFollowing(){
        try{
            $user = auth()->userOrFail();
        } catch (Exception $e){
            return response()->json([], 401);
        }
        $user = User::with('followees')->findOrFail($user->id);
        return response()->json($user, 200);
    }
}
