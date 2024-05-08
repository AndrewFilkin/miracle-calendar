<?php


namespace App\Services\Api\Admin\Auth;


use App\Models\User;

class DeleteUserService
{
    public $answer;

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            if ($user->role == 'admin') {
                $this->answer = response()->json(['message' => 'You can not delete admin'], 403);
                return;
            }
            $user->delete();
            $this->answer = response()->json(['message' => 'User deleted successfully.'], 200);
        } else {
            $this->answer = response()->json(['message' => 'User not found.'], 404);
        }
    }
}
