<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Exception\JWTException;
use JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    {
      $this->validate($request,[
        'email' => 'email|unique:users|required|string',
        'password' => 'required|min:6|string',
        'name' => 'required'
      ]);

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password)
      ]);

      return response()->json([
        'message' => 'User created.'
      ],201);
    }

    public function login(Request $request)
    {
      $this->validate($request,[
        'email' => 'email|required|string',
        'password' => 'required|min:6|string'
      ]);
      $credentials = $request->only('email','password');
      try {
        if (!$token = JWTAuth::attempt($credentials)) {
          return response()->json([
            'error' => 'Invalid credentials'
          ],401);
        }
      } catch (JWTException $e) {
        return response()->json([
          'error' => 'Could not created authentication'
        ],500);
      }
      return response()->json([
        'token' => $token
      ],200);
    }
}
