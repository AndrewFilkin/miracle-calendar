<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\SearchQueryRequest;
use App\Models\User;

class UserSearchController extends Controller
{
    public function searchApprovedUsers(SearchQueryRequest $request)
    {
        $messageNotFound = array(
            "name" => array(
                'Not found',
            )
        );

        $currentUserId = auth()->user()->id;

        $query = $request->get('query', '');
        $results = User::where('name', 'ILIKE', "%{$query}%")
            ->where('is_approved', '=', true)
            ->where('id', '!=', $currentUserId)->get();

        if (!$results->isEmpty()) {
            return response()->json($results);
        } else {
            return response()->json([$messageNotFound]);
        }
    }

    public function searchNotApprovedUsers(SearchQueryRequest $request)
    {
        $messageNotFound = array(
            "name" => array(
                'Not found',
            )
        );

        $currentUserId = auth()->user()->id;

        $query = $request->get('query', '');
        $results = User::where('name', 'ILIKE', "%{$query}%")
            ->where('is_approved', '=', false)
            ->where('id', '!=', $currentUserId)->get();

        if (!$results->isEmpty()) {
            return response()->json($results);
        } else {
            return response()->json([$messageNotFound]);
        }
    }
}
