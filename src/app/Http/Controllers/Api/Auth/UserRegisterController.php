<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\UpdateUserRequest;
use App\Models\User;
use App\Services\Api\Auth\RegisterUserService;
use App\Http\Requests\Api\Auth\LoginRequest;

class UserRegisterController extends Controller
{
    public function register($code, RegisterRequest $request, RegisterUserService $registerUser)
    {
        $registerUser->registerUser($code, $request);

        return $registerUser->answer;
    }

    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();

        if (!$token = auth()->attempt($credentials) or $user->is_approved == false) {
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
            'expires_in' => auth()->factory()->getTTL() * 60 * 24 * 365, // 1 year
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'role' => auth()->user()->role,
        ]);
    }

}
