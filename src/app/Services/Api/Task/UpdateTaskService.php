<?php

namespace App\Services\Api\Task;

use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Models\Task;

class UpdateTaskService
{
    public $answer;

    public function updateTask($id, UpdateTaskRequest $request)
    {
        $task = Task::find($id);

        if (empty($task)) {
            $this->answer = response()->json(['message' => "Task $id not found"], 404);
            return;
        }

        if (auth()->user()->id == $task->creator_id || auth()->user()->role == 'admin') {
            $data = $request->only(['name', 'description', 'start_date', 'end_date', 'is_urgently', 'is_completed',]);
            $result = $task->fill($data)->save();

            if ($result) {
                $this->answer = response()->json(['message' => 'Task updated successfully'], 200);
            } else {
                $this->answer = response()->json(['message' => 'Task updated error'], 404);
            }
        } else {
            $this->answer = response()->json(['message' => 'Access is closed, task update can only be done by task creator or administrator'], 403);
        }
    }
}
