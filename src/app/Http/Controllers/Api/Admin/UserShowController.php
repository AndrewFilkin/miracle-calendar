<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\Api\Admin\UserResource;

class UserShowController extends Controller
{
    public function showIsApprovedUsers()
    {
        $id = auth()->user()->id;

        $users = User::where('is_approved', true)
            ->where('id', '!=', $id)
            ->paginate(30);

        return UserResource::collection($users);
    }

    public function showIsNotApprovedUsers()
    {
        $id = auth()->user()->id;

        $users = User::where('is_approved', false)
            ->where('id', '!=', $id)
            ->paginate(30);

        return UserResource::collection($users);
    }
}
