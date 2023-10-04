<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request){

        // register user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'rol' => $request->input('rol'),
            'password' => bcrypt($request->input('password')),
        ]);

        // create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
    
        $user = User::where('email', $request['email'])->firstOrFail();
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    } 
    
    public function unauthenticated()
    {
        return "Unauthenticated";
    }

    public function testToken(){

        // find user by email
        $user = User::where('email', 'admin@test.es')->first();
    
        // $user->currentAccessToken()->delete();
        // $token = $user->createToken('auth_token')->plainTextToken;
    
        // return Auth::user()->tokens();

        return $user->tokens();
    }    
}
