<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class SactumController extends Controller
{
     public function register(Request $request)
     {
         $fields = $request->validate([
             'name' => 'required|string',
             'email' => 'required|string|unique:users,email',
             'password' => 'required|string|confirmed',
             'first_name' => 'required|string',
             'identifier' => 'required|string',
             'status' => 'required|string'
         ]);

         $user = User::create([
             'name' => $fields['name'],
             'email' => $fields['email'],
             'first_name' => $fields['first_name'],
             'identifier' => $fields['identifier'],
             'status' => $fields['status'],
             'password' => bcrypt($fields['password'])
         ]);

         $token = $user->createToken('myapptoken')->plainTextToken;

         $response = [
             'user' => $user,
             'token' => $token
         ];

         return response($response, 201);
     }

     public function login(Request $request)
     {
         $fields = $request->validate([
             'email' => 'required|string',
             'password' => 'required|string',
         ]);

         $user = User::where('email',$fields['email'])->first();

         if(!$user || !Hash::check($fields['password'],$user->password)) {
             return response([
                 'message' => 'Bad login'
             ], 401);
         }

         $token = $user->createToken('myapptoken')->plainTextToken;

         $response = [
             'user' => $user,
             'token' => $token
         ];

         return response($response, 201);
     }

     public function logout(Request $request)
     {
         auth()->user()->tokens()->delete();

         return [
             'message' => 'Logged out'
         ];
     }

}
