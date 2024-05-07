<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Models\Task;
use App\Services\Api\Task\CreateTaskService;
use App\Http\Requests\Api\Task\UpdateTaskRequest;

class TaskController extends Controller
{
    public function create(CreateTaskRequest $request, CreateTaskService $createTaskService)
    {
        $createTaskService->createTask($request);

        return $createTaskService->answer;
    }

    public function update($id, UpdateTaskRequest $request)
    {
        $task = Task::find($id);

        if (empty($task)) {
            return response()->json(['message' => "Task $id not found"], 404);
        }

        if (auth()->user()->id !== $task->creator_id) {
            return response()->json(['message' => 'Access closed, you are not creator'], 403);
        }

        $data = $request->only(['name', 'description', 'start_date', 'end_date']);
        $result = $task->fill($data)->save();

        if ($result) {
            return response()->json(['message' => 'Task updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Task updated error'], 404);
        }
    }
}
