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

        //create comment
        try {
            $comment = Comment::create([
                'user_id' => $creator,
                'task_id' => $task->id,
                'comment' => $requestData['comment'],
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $fileOriginalName = $file->getClientOriginalName();
                    $fileNameInStorage = Str::random(32) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs("public/files/task/$request->task_id/", $fileNameInStorage);

                    //save data to db, table - files
                    $file = new File([
                        'user_id' => $creator,
                        'file_name_in_storage' => $fileNameInStorage,
                        'original_name' => $fileOriginalName,
                    ]);
                    $comment->files()->save($file);
                }
            }

            if ($comment && $task) {
                $this->answer = response()->json(['message' => 'Task created'], 201);
            } else {
                $this->answer = response()->json(['message' => 'Error task created'], 500);
            }
        } catch (\Error $e) {
            $this->answer = response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
