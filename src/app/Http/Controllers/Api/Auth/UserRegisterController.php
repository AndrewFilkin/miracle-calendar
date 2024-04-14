<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Api\Auth\RegisterUserService;

class UserRegisterController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserService $registerUser)
    {
        // register user
        $registerUser->registerUser($request);

        // return answer and status code (json)
        return $registerUser->answer;
    }
}
