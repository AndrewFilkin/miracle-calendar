<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Api\Admin\Auth\GenerateRegisterLinkService;

class GenerateRegisterLinkController extends Controller
{
    public function generate(GenerateRegisterLinkService $generateRegisterLinkService)
    {
        $generateRegisterLinkService->generateRegisterLink();

        return $generateRegisterLinkService->answer;
    }
}
