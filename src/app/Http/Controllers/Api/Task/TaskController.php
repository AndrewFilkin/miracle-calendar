<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\FilterRequest;
use App\Http\Requests\Api\Task\SearchQueryRequest;
use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Http\Resources\Api\Task\ShowUserResource;
use App\Models\File;
use App\Models\Task;
use App\Models\User;
use App\Services\Api\Task\CreateTaskService;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Services\Api\Task\DeleteTaskService;
use App\Services\Api\Task\UpdateTaskService;
use App\Services\Api\Task\ShowTaskService;
use App\Models\Comment;

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

    public function showConcreteTask($taskId)
    {

        $id = auth()->user()->id;
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $userIdsWhoCanSeeThisTask = $task->users()->get()->pluck('id')->toArray();
        if (!in_array($id, $userIdsWhoCanSeeThisTask)) {
            return response()->json(['message' => 'You cannot open someone else task'], 403);
        }

        $comments = Comment::where('task_id', $taskId)
            ->get();

        foreach ($comments as $comment) {
            $comment['file'] = "/storage/files/task/$taskId/" . File::where('comment_id', $comment->id)
                ->value('file_name_in_storage');
        }

        return response()->json(['task' => $task, 'comments' => $comments]);
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

    public function searchAllTask(SearchQueryRequest $request) {

        $messageNotFound = array(
            "name" => array(
                'Not found',
            )
        );

        $query = $request->get('query', '');

        if (auth()->user()->role == "admin") {
            $tasks = Task::where('name', 'ILIKE', "%{$query}%")
                ->get();
        } else {
            $currentUserId = auth()->user()->id;
            $tasks = User::find($currentUserId)
                ->tasks()
                ->where('name', 'ILIKE', "%{$query}%")
                ->get();
        }

        if (!$tasks->isEmpty()) {
            return response()->json($tasks);
        } else {
            return response()->json([$messageNotFound]);
        }
    }

    public function searchAllCompletedTask(SearchQueryRequest $request) {

    }

    public function searchAllNotCompletedTask(SearchQueryRequest $request) {

    }

}
