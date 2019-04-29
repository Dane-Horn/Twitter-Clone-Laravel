<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Uuid;
class AuthController extends Controller
{
    protected function respondWithToken($token){
        return response()->json([
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request){
        $user = new User([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);
        $user->id = Uuid::generate();
        $user->save();
        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }

    public function login(){
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials))
            return response()->json([], 401);
        return response()->json(['token' => $token], 200);
    }

    public function logout(){
        auth()->logout();
        return response()->json([], 204);
    }

    public function me(){
        $user = auth()->userOrFail();
        return response()->json(["user" => $user], 200);
    }
}
