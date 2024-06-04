<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\LoginRequest;
use App\Http\Requests\user\RegisterRequest;
use App\Http\Resources\user\RespondToken;
use App\Http\Resources\user\UserInfoResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): UserInfoResource
    {
        $user = User::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password")),
        ]);

        return new UserInfoResource($user);
    }

    public function login(LoginRequest $request): JsonResponse|RespondToken
    {
        if (!$token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return new RespondToken((object)["token" => $token]);

    }

    public function refresh(): RespondToken
    {
        $token = (object)["token" => Auth::refresh()];

        return new RespondToken($token);
    }

    public function me(): UserInfoResource
    {
        return new UserInfoResource(\auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
