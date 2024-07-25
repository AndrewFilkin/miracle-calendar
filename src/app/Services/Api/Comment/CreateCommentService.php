<?php

namespace App\Services\Api\Comment;

use App\Http\Requests\Api\Comment\CreateCommentRequest;
use App\Models\Comment;
use App\Models\File;
use Illuminate\Support\Str;

class CreateCommentService
{
    public $answer;

    public function createComment(CreateCommentRequest $request)
    {
        $creator = auth()->user()->id;

        try {
            $comment = Comment::create([
                'user_id' => $creator,
                'task_id' => $request->task_id,
                'comment' => $request->comment,
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileOriginalName = $file->getClientOriginalName();
                    $fileNameInStorage = Str::random(32) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs("public/files/task/$request->task_id/" . 'comment_id_' . "$comment->id", $fileNameInStorage);

                    //save data to db, table - files
                    $file = new File([
                        'user_id' => $creator,
                        'file_name_in_storage' => $fileNameInStorage,
                        'original_name' => $fileOriginalName,
                    ]);
                    $comment->files()->save($file);
                }
            }

            if ($comment) {
                $this->answer = response()->json(['message' => 'Comment created'], 201);
            } else {
                $this->answer = response()->json(['message' => 'Error comment created'], 500);
            }
        } catch (\Error $e) {
            $this->answer = response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
