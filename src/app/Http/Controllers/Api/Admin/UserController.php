<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\UpdateUserRequest;
use App\Services\Api\Admin\Auth\DeleteUserService;
use App\Services\Api\Auth\UpdateUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function update($id, UpdateUserRequest $request, UpdateUserService $updateUser)
    {
        $updateUser->updateUser($id, $request);

        return $updateUser->answer;
    }

    public function delete($id, DeleteUserService $deleteUserService)
    {
        $deleteUserService->deleteUser($id);
        return $deleteUserService->answer;
    }
}
