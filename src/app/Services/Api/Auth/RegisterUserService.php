<?php


namespace App\Services\Api\Auth;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Auth\RegisterRequest;

class RegisterUserService
{

    public JsonResponse $answer;

    public function registerUser(RegisterRequest $request): void
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'vk_link' => $request->vk_link,
            'password' => Hash::make($request->password),
        ]);

        if ($user->wasRecentlyCreated) {
            $this->answer = response()->json('register success', 201);
        } else {
            $this->answer = response()->json('something wrong', 409);
        }
    }
}
