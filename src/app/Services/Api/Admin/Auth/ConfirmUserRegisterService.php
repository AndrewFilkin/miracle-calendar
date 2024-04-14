<?php


namespace App\Services\Api\Admin\Auth;


use App\Models\User;
use App\Http\Requests\Api\Admin\Auth\ConfirmUserRegisterRequest;

class ConfirmUserRegisterService
{
    public $answer;

    public function confirm(ConfirmUserRegisterRequest $request): void
    {
        $email = $request->only('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->confirm == true) {
                $this->answer = response()->json('user already confirm', 409);
            } else {
                $user->confirm = true;
                $user->save();
                $this->answer = response()->json('success confirm user', 200);
            }
        } else {
            $this->answer = response()->json('something wrong', 409);
        }
    }
}
