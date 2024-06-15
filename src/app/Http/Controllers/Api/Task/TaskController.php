<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Http\Resources\Api\Admin\UserResource;
use App\Models\Task;
use App\Models\User;
use App\Services\Api\Task\CreateTaskService;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Services\Api\Task\DeleteTaskService;
use App\Services\Api\Task\UpdateTaskService;

class TaskController extends Controller
{

    public function showUser()
    {
        $id = auth()->user()->id;

        $users = User::where('is_approved', true)
            ->where('id', '!=', $id)
            ->get();

        return UserResource::collection($users)->resolve();
    }

    public function create(CreateTaskRequest $request, CreateTaskService $createTaskService)
    {
        $createTaskService->createTask($request);

        return $createTaskService->answer;
    }

    public function update($id, UpdateTaskRequest $request, UpdateTaskService $updateTaskService)
    {
        $updateTaskService->updateTask($id, $request);

        return $updateTaskService->answer;
    }

    public function delete($id, DeleteTaskService $deleteTaskService)
    {
        $deleteTaskService->deleteTask($id);
        return $deleteTaskService->answer;
    }
}
