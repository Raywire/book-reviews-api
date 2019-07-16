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
        $statusCode = 201;

        $token = auth()->login($user);

        return $this->respondWithToken($token, $currentUser, $statusCode);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only(['email', 'password']);

        $statusCode = 200;

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'message' => 'Invalid credentials'], 401);
        }

        $user = $request->user();
        $currentUser = ['email' => $user->email, 'name' => $user->name];

        return $this->respondWithToken($token, $currentUser, $statusCode);
    }

    protected function respondWithToken($token, $currentUser, $statusCode)
    {
        return response()->json([
            'user' => $currentUser,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], $statusCode);
    }
}
