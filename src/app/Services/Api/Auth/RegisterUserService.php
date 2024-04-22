<?php


namespace App\Services\Api\Auth;


use App\Models\User;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Support\Facades\DB;

class RegisterUserService
{

    public $answer;

    public function registerUser(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->vk_link = $request->vk_link;
        $user->password = bcrypt($request->password);

        DB::beginTransaction();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('public/avatars', $avatarName);
            $user->avatar = $avatarName;
            $user->save();
            DB::commit();
        } else {
            $user->save();
            DB::commit();
        }

        if ($user->wasRecentlyCreated) {
            $this->answer = response()->json(['message' => 'register success'], 201);
        } else {
            DB::rollBack();
            $this->answer = response()->json(['message' => 'something wrong'], 409);
        }
    }
}
