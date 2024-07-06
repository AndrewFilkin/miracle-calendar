<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\UpdateUserRequest;
use App\Services\Api\Auth\RegisterUserService;
use App\Http\Requests\Api\Auth\LoginRequest;

class UserRegisterController extends Controller
{
    public function register($code, RegisterRequest $request, RegisterUserService $registerUser)
    {
        $registerUser->registerUser($code, $request);

        return $registerUser->answer;
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
//            'expires_in' => auth()->factory()->getTTL() * 60 * 24 * 365 // 1 year
        ]);
    }

}
