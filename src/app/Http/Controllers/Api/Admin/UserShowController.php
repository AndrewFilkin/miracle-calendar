<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\FilterRequest;
use App\Models\User;
use App\Http\Resources\Api\Admin\UserResource;

class UserShowController extends Controller
{
    public function showIsApprovedUsers(FilterRequest $request)
    {
        $filter = $request->filter;
        $id = auth()->user()->id;

        switch ($filter) {
            case 'asc':
                $users = User::where('is_approved', true)
                    ->where('id', '!=', $id)
                    ->orderBy('name', 'asc')
                    ->paginate(30);
                return UserResource::collection($users);

            case 'desc':
                $users = User::where('is_approved', true)
                    ->where('id', '!=', $id)
                    ->orderBy('name', 'desc')
                    ->paginate(30);
                return UserResource::collection($users);

            default:
                $users = User::where('is_approved', true)
                    ->where('id', '!=', $id)
                    ->paginate(30);

                return UserResource::collection($users);
        }
    }

    public function showIsNotApprovedUsers(FilterRequest $request)
    {
        $filter = $request->filter;
        $id = auth()->user()->id;

        switch ($filter) {
            case 'asc':
                $users = User::where('is_approved', false)
                    ->where('id', '!=', $id)
                    ->orderBy('name', 'asc')
                    ->paginate(30);
                return UserResource::collection($users);

            case 'desc':
                $users = User::where('is_approved', false)
                    ->where('id', '!=', $id)
                    ->orderBy('name', 'desc')
                    ->paginate(30);
                return UserResource::collection($users);

            default:
                $users = User::where('is_approved', false)
                    ->where('id', '!=', $id)
                    ->paginate(30);

                return UserResource::collection($users);
        }
    }
}
