<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserSortController extends Controller
{
    public function sortAscIsApprovedUser()
    {
        $id = auth()->user()->id;

        $users = User::where('is_approved', true)
            ->where('id', '!=', $id)
            ->orderBy('name', 'asc')
            ->paginate(30);

        return UserResource::collection($users);
    }

    public function sortAscIsNotApprovedUser()
    {
        $id = auth()->user()->id;

        $users = User::where('is_approved', false)
            ->where('id', '!=', $id)
            ->orderBy('name', 'asc')
            ->paginate(30);

        return UserResource::collection($users);
    }

    public function sortDescIsApprovedUser()
    {
        $id = auth()->user()->id;

        $users = User::where('is_approved', true)
            ->where('id', '!=', $id)
            ->orderBy('name', 'desc')
            ->paginate(30);

        return UserResource::collection($users);
    }

    public function sortDescIsNotApprovedUser()
    {
        $id = auth()->user()->id;

        $users = User::where('is_approved', false)
            ->where('id', '!=', $id)
            ->orderBy('name', 'desc')
            ->paginate(30);

        return UserResource::collection($users);
    }

}
