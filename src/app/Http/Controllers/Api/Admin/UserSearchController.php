<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\SearchQueryRequest;
use App\Models\User;

class UserSearchController extends Controller
{
    public function searchApprovedUsers(SearchQueryRequest $request)
    {
        $currentUserId = auth()->user()->id;

        $query = $request->get('query', '');
        $results = User::where('name', 'ILIKE', "%{$query}%")
            ->where('is_approved', '=', true)
            ->where('id', '!=', $currentUserId)->get();

        return response()->json($results);
    }

    public function searchNotApprovedUsers(SearchQueryRequest $request)
    {
        $currentUserId = auth()->user()->id;

        $query = $request->get('query', '');
        $results = User::where('name', 'ILIKE', "%{$query}%")
            ->where('is_approved', '=', false)
            ->where('id', '!=', $currentUserId)->get();

        return response()->json($results);
    }
}
