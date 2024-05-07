<?php

namespace App\Services\Api\Project;

use App\Http\Requests\Api\Project\CreateProjectRequest;
use App\Models\Project;

class CreateProjectService
{
    public $answer;

    public function createProject(CreateProjectRequest $request)
    {
        $creator = auth()->user()->id;

        $requestData = $request->only(['name', 'description', 'participant']);

        $project = Project::create([
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'creator_id' => $creator,
        ]);

        // participant is array and have users why can use project

        if (!isset($requestData['participant'])) {
            $requestData['participant'] = (string)$creator;
            $project->users()->attach($requestData['participant']);
        } else {
            array_push($requestData['participant'], (string)$creator);
            $participant = array_unique($requestData['participant']);
            $project->users()->attach($participant);
        }

        $this->answer = response()->json(['message' => 'project created'], 201);
    }
}
