<?php


namespace App\Services\Api\Auth;


use App\Http\Requests\Api\Auth\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateUserService
{
    public $answer;

    public function updateUser(UpdateUserRequest $request)
    {
        if (auth()->user()) {

            $id = auth()->user()->id;
            $user = User::find($id);

            $data = $request->only(['name', 'email', 'vk_link', 'content']);

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
        } else {
            return $this->answer = response()->json(['message' => "Access closed"], 403);
        }
    }
}
