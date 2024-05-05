<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Services\Api\Task\CreateTaskService;

class TaskController extends Controller
{
    public function create(CreateTaskRequest $request, CreateTaskService $createTaskService)
    {
        $createTaskService->createTask($request);

        return $createTaskService->answer;
    }
}
