<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Auth\ApprovedUserRegisterRequest;
use App\Models\User;
use App\Services\Api\Admin\Auth\ApprovedUserRegisterService;

class ApprovedUserRegisterController extends Controller
{
    public function approvedUserRegister(ApprovedUserRegisterRequest $request, ApprovedUserRegisterService $confirm)
    {
        //confirm user
        $confirm->approved($request);
        // spend answer
        return $confirm->answer;
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ($user) {
            if ($user->role == 'admin') {
                return response()->json(['message' => 'You can not delete admin'], 403);
            }
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }


    }
}
