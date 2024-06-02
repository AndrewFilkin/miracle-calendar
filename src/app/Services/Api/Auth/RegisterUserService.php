<?php

namespace App\Services\Api\Auth;

use App\Models\User;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\RegisterLink;

class RegisterUserService
{
    public $answer;
    const MAX_EXPIRE_DAYS = 2;

    public function registerUser($code, RegisterRequest $request)
    {

        $registerCode = RegisterLink::where('code', '=', $code)->first();

        if (!$registerCode) {
            $this->answer = response()->json(['message' => 'The link is incorrect, please contact your administrator.'], 409);
            return;
        }

        $now = Carbon::now();
        $createdAt = Carbon::parse($registerCode->created_at);

        if ($createdAt->diffInDays($now) > self::MAX_EXPIRE_DAYS) {
            $this->answer = response()->json(['message' => 'The link has expired, please contact your administrator.'], 409);
            return;
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
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
