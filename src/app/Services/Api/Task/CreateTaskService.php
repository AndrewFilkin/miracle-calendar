<?php


namespace App\Services\Api\Task;


use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Models\Comment;
use App\Models\Task;
use App\Models\File;
use Illuminate\Support\Str;

class CreateTaskService
{

    public $answer;

    public function createTask(CreateTaskRequest $request)
    {
        $creator = auth()->user()->id;

        $requestData = $request->only(['name', 'description', 'start_date', 'end_date', 'is_urgently', 'participant', 'comment']);

        $task = Task::create([
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'start_date' => $requestData['start_date'],
            'end_date' => $requestData['end_date'],
            'is_urgently' => $requestData['is_urgently'],
            'creator_id' => $creator,
        ]);

        if (!isset($requestData['participant'])) {
            $requestData['participant'] = (string)$creator;
            $task->users()->attach($requestData['participant']);
        } else {
            array_push($requestData['participant'], (string)$creator);
            $participant = array_unique($requestData['participant']);
            $task->users()->attach($participant);
        }

        $this->answer = response()->json(['message' => 'Task created'], 201);


        //create Checklist


        //create comment
        $comment = new Comment();
        try {
            if (array_key_exists('comment', $requestData)) {

                $comment->user_id = $creator;
                $comment->task_id = $task->id;
                $comment->comment = $requestData['comment'];
                $comment->save();
                $this->answer = response()->json(['message' => 'Task created'], 201);
            }

            if ($request->hasFile('files') and $comment->exists) {
                foreach ($request->file('files') as $file) {
                    $fileOriginalName = $file->getClientOriginalName();
                    $fileNameInStorage = Str::random(32) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs("public/files/task/$task->id/" . 'comment_id_'. "$comment->id", $fileNameInStorage);

                    //save data to db, table - files
                    $file = new File([
                        'user_id' => $creator,
                        'file_name_in_storage' => $fileNameInStorage,
                        'original_name' => $fileOriginalName,
                    ]);
                    $comment->files()->save($file);
                }
                $this->answer = response()->json(['message' => 'Task created'], 201);
            } elseif ($request->hasFile('files')) {

                $comment = Comment::create([
                    'user_id' => $creator,
                    'task_id' => $task->id,
                    'comment' => ' ',
                ]);

                foreach ($request->file('files') as $file) {
                    $fileOriginalName = $file->getClientOriginalName();
                    $fileNameInStorage = Str::random(32) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs("public/files/task/$task->id/" . 'comment_id_'. "$comment->id", $fileNameInStorage);

                    //save data to db, table - files
                    $file = new File([
                        'user_id' => $creator,
                        'file_name_in_storage' => $fileNameInStorage,
                        'original_name' => $fileOriginalName,
                    ]);
                    $comment->files()->save($file);
                }
                $this->answer = response()->json(['message' => 'Task created'], 201);
            }

        } catch (\Error $e) {
            $this->answer = response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
