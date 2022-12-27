<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('Token')->accessToken;
        return response()->json(['token' => $token, 'user' => $user], 200);
        // dd($user);
    }

    public function login(Request $request)
    {
        $data = [

            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($data)) {

            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'unauthorized'], 401);
        }
    }

    public function userinfo()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }
}
