<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Auth\ApprovedUserRegisterRequest;
use App\Models\User;
use App\Services\Api\Admin\Auth\ApprovedUserRegisterService;
use App\Services\Api\Admin\Auth\DeleteUserService;

class ApprovedUserRegisterController extends Controller
{
    public function approvedUserRegister(ApprovedUserRegisterRequest $request, ApprovedUserRegisterService $confirm)
    {
        $confirm->approved($request->validated());
        return $confirm->answer;
    }
}
