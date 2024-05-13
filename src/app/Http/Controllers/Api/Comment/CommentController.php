<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\CreateCommentRequest;
use App\Services\Api\Comment\CreateCommentService;

class CommentController extends Controller
{

    public function create(CreateCommentRequest $request, CreateCommentService $commentService)
    {
        $commentService->createComment($request);
        return $commentService->answer;
    }
}
