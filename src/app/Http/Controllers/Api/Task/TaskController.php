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
use Carbon\Carbon;

class TaskController extends Controller
{

    /*
    посмотреть все задачи которые сам создал и ему создали
    из таблицы task_user
    */

    public function showTask(FilterRequest $request)
    {
//        $data = $request->validated();

        $filterFirst = $request->filterFirst;
        $filterSecond = $request->filterSecond;

        $id = auth()->user()->id;

        switch ($filterFirst) {

            case 'asc':
                $user = User::find($id);
                $tasks = $user->tasks()
                    ->orderBy('name', 'asc')
                    ->paginate(30);
                return response()->json($tasks);

            case 'desc':
                $user = User::find($id);
                $tasks = $user->tasks()
                    ->orderBy('name', 'desc')
                    ->paginate(30);
                return response()->json($tasks);

            case 'completed':
                switch ($filterSecond) {
                    case 'asc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', true)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return response()->json($tasks);

                    case 'desc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', true)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return response()->json($tasks);

                    default:
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', true)
                            ->paginate(30);
                        return response()->json($tasks);
                }

            case 'not_completed':
                switch ($filterSecond) {
                    case 'asc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', false)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return response()->json($tasks);

                    case 'desc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', false)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return response()->json($tasks);

                    default:
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('is_completed', '=', false)
                            ->paginate(30);
                        return response()->json($tasks);
                }
            case 'expired':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '<', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return response()->json($tasks);

                    case 'desc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '<', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return response()->json($tasks);

                    default:
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '<', $currentDate)
                            ->paginate(30);
                        return response()->json($tasks);
                }

            case 'not_expired':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '>', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return response()->json($tasks);

                    case 'desc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '>', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return response()->json($tasks);

                    default:
                        $currentDate = Carbon::now();

                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->where('end_date', '>', $currentDate)
                            ->paginate(30);
                        return response()->json($tasks);
                }

            case 'without_expired':
                switch ($filterSecond) {
                    case 'asc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereNull('end_date')
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return response()->json($tasks);

                    case 'desc':
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereNull('end_date')
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return response()->json($tasks);

                    default:
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereNull('end_date')
                            ->paginate(30);
                        return response()->json($tasks);
                }

            case 'current_date':
                switch ($filterSecond) {
                    case 'asc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $currentDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return response()->json($tasks);
                    case 'desc':
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $currentDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return response()->json($tasks);
                    default:
                        $currentDate = Carbon::now();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $currentDate)
                            ->paginate(30);
                        return response()->json($tasks);
                }

            case 'specific_date':
                switch ($filterSecond) {
                    case 'asc':
                        $specificDate = Carbon::parse($request->specific_date);
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $specificDate)
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return response()->json($tasks);
                    case 'desc':
                        $specificDate = Carbon::parse($request->specific_date);
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $specificDate)
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return response()->json($tasks);
                    default:
                        $specificDate = Carbon::parse($request->specific_date);
                        //Если specific_date не была указана
                        if ($specificDate->minute == Carbon::now()->minute) {
                            return response()->json(['message' => 'Task not found'], 404);
                        }

                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereDate('start_date', '=', $specificDate)
                            ->paginate(30);
                        return response()->json($tasks);
                }


            case 'between_date':
                switch ($filterSecond) {
                    case 'asc':
                        $startDate = Carbon::parse($request->start_date)->startOfDay();
                        $endDate = Carbon::parse($request->end_date)->endOfDay();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereBetween('start_date', [$startDate, $endDate])
                            ->orderBy('name', 'asc')
                            ->paginate(30);
                        return response()->json($tasks);

                    case 'desc':
                        $startDate = Carbon::parse($request->start_date)->startOfDay();
                        $endDate = Carbon::parse($request->end_date)->endOfDay();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereBetween('start_date', [$startDate, $endDate])
                            ->orderBy('name', 'desc')
                            ->paginate(30);
                        return response()->json($tasks);

                    default:
                        $startDate = Carbon::parse($request->start_date)->startOfDay();
                        $endDate = Carbon::parse($request->end_date)->endOfDay();
                        $user = User::find($id);
                        $tasks = $user->tasks()
                            ->whereBetween('start_date', [$startDate, $endDate])
                            ->paginate(30);
                        return response()->json($tasks);
                }

            default:
                $user = User::find($id);
                $tasks = $user->tasks()->paginate(30);
                return response()->json($tasks);
        }
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
