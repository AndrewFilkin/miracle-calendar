<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function create(CreateTaskRequest $request)
    {
        $creator = auth()->user()->id;

        $requestData = $request->only(['project_id', 'name', 'description', 'start_date', 'end_date', 'participant']);

        $task = Task::create([
            'project_id' => $requestData['project_id'],
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'start_date' => $requestData['start_date'],
            'end_date' => $requestData['end_date'],
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

        return response()->json(['message' => 'task created'], 201);
    }
}
