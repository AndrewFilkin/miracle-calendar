<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserShowController extends Controller
{
    public function showIsApprovedUsers()
    {
        $users = User::where('is_approved', true)->paginate(30);

        return response()->json([$users], 200);
    }
}
