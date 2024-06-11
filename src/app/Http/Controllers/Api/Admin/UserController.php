<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Api\Admin\Auth\DeleteUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function delete($id, DeleteUserService $deleteUserService)
    {
        $deleteUserService->deleteUser($id);
        return $deleteUserService->answer;
    }
}
