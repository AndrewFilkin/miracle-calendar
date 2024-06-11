<?php


namespace App\Services\Api\Auth;


use App\Http\Requests\Api\Auth\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UpdateUserService
{
    public $answer;

    public function updateUser($id, UpdateUserRequest $request)
    {
        $user = User::find($id);

        if (!$user) {
            $this->answer = response()->json(['message' => 'User not found.'], 404);
            return;
        }

        $data = $request->only(['name', 'email', 'vk_link', 'content', 'password']);

        if ($request->password) {
            $data['password'] = Hash::make($data['password']);
        }

        try {
            $result = $user->fill($data);
            DB::beginTransaction();

            if ($request->hasFile('avatar')) {
                // Delete previous avatar
                Storage::delete('public/avatars/' . $user->avatar);
                // Create new avatar
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->storeAs('public/avatars', $avatarName);
                $user->avatar = $avatarName;
                $result->save();
                DB::commit();
                $this->answer = response()->json(['message' => 'update success'], 201);
            } else {
                $result->save();
                DB::commit();
                $this->answer = response()->json(['message' => 'update success'], 201);
            }

        } catch (QueryException $e) {
            return $this->answer = response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (Exception $e) {
            return $this->answer = response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
