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

        $this->answer = response()->json(['message' => 'task created'], 201);
    }
}
