<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $name = $request->name;
        $email = $request->email;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($request->password),
        ]);
        $currentUser = ['email' => $email, 'name' => $name ];

        $token = auth()->login($user);

        return $this->respondWithToken($token, $currentUser);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only(['email', 'password']);
        $currentUser = ['email' => $request['email']];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'message' => 'Invalid credentials'], 401);
        }

        return $this->respondWithToken($token, $currentUser);
    }

    protected function respondWithToken($token, $currentUser)
    {
        return response()->json([
            'user' => $currentUser,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
