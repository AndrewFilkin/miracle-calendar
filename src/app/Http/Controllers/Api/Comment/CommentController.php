<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\CreateCommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function create(CreateCommentRequest $request)
    {
        $creator = auth()->user()->id;

        $requestData = $request->only(['task_id', 'comment']);

        $comment = Comment::create([
            'user_id' => $creator,
            'task_id' => $requestData['task_id'],
            'comment' => $requestData['comment'],
        ]);

        if ($comment) {
            return response()->json(['message' => 'Comment created'], 201);
        } else {
            return response()->json(['message' => 'Error comment created'], 500);
        }

    }
}
