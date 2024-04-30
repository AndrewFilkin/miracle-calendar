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

        if (isset($requestData['participant'])) {
            $project->users()->attach($requestData['participant']);
        }

        $this->answer = response()->json(['message' => 'project created'], 201);
    }
}
