<?php


namespace App\Services\Api\Task;


use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Models\Task;

class CreateTaskService
{

    public $answer;

    public function createTask(CreateTaskRequest $request)
    {
        $creator = auth()->user()->id;

        $requestData = $request->only(['project_id', 'name', 'description', 'start_date', 'end_date', 'is_urgently', 'is_completed']);

        Task::create([
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'start_date' => $requestData['start_date'],
            'end_date' => $requestData['end_date'],
            'is_completed' => $requestData['is_completed'],
            'is_urgently' => $requestData['is_urgently'],
            'creator_id' => $creator,
        ]);

        $this->answer = response()->json(['message' => 'task created'], 201);
    }
}
