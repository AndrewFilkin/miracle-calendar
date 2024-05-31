<?php


namespace App\Services\Api\Admin\Auth;


use App\Models\User;
use App\Http\Requests\Api\Admin\Auth\ApprovedUserRegisterRequest;

class ApprovedUserRegisterService
{
    public $answer;

    public function approved(array $validatedData): void
    {
        $email = $validatedData['email'];
        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->is_approved == true) {
                $this->answer = response()->json(['message' => 'user already approved'], 409);
            } else {
                $user->is_approved = true;
                $user->save();
                $this->answer = response()->json(['message' => 'success approved user'], 200);
            }
        } else {
            $this->answer = response()->json(['message' => 'something wrong'], 409);
        }
    }
}
