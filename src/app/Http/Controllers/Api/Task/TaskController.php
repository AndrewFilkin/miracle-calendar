<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\FilterRequest;
use App\Http\Requests\Api\Task\SearchQueryRequest;
use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Http\Resources\Api\Task\ShowUserResource;
use App\Models\User;
use App\Services\Api\Task\CreateTaskService;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Services\Api\Task\DeleteTaskService;
use App\Services\Api\Task\UpdateTaskService;
use App\Services\Api\Task\ShowTaskService;

class TaskController extends Controller
{

    /*
    посмотреть все задачи которые сам создал и ему создали
    из таблицы task_user
    */

    public function showTask(FilterRequest $request, ShowTaskService $showTaskService)
    {
        $data = $request->validated();
        $id = auth()->user()->id;

        $showTaskService->showTask($data, $id);
        return $showTaskService->answer;
    }

    public function showTaskInCalendar()
    {
        $id = auth()->user()->id;

        $user = User::find($id);
        $tasks = $user->tasks()->orderBy('start_date')->get();
        return response()->json($tasks);
    }

    public function showUser()
    {
        $id = auth()->user()->id;

        $users = User::where('is_approved', true)
            ->where('id', '!=', $id)
            ->get();

        return ShowUserResource::collection($users)->resolve();
    }

    public function searchUser(SearchQueryRequest $request)
    {
        $messageNotFound = array(
            "name" => array(
                'Not found',
            )
        );

        $currentUserId = auth()->user()->id;

        $query = $request->get('query', '');

        $results = User::where('name', 'ILIKE', "%{$query}%")
            ->where('is_approved', '=', true)
            ->where('id', '!=', $currentUserId)->get();

        if (!$results->isEmpty()) {
            return response()->json($results);
        } else {
            return response()->json([$messageNotFound]);
        }
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
