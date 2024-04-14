<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Auth\ConfirmUserRegisterRequest;
use App\Services\Api\Admin\Auth\ConfirmUserRegisterService;
use function Symfony\Component\HttpKernel\Log\clear;

class ConfirmUserRegisterController extends Controller
{
    public function confirmUserRegister(ConfirmUserRegisterRequest $request, ConfirmUserRegisterService $confirm)
    {
        //confirm user
        $confirm->confirm($request);
        // spend answer
        return $confirm->answer;
    }
}
