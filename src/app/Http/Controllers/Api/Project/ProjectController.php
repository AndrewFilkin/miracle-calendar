<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\CreateProjectRequest;
use App\Http\Requests\Api\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Api\Project\CreateProjectService;

class ProjectController extends Controller
{
    public function create(CreateProjectRequest $request, CreateProjectService $createProjectService)
    {
        $createProjectService->createProject($request);

        return $createProjectService->answer;
    }

    public function update($id, UpdateProjectRequest $request)
    {

        $project = Project::find($id);

        if (auth()->user()->id !==  $project->creator_id) {
            return response()->json(['message' => 'Access closed, you are not creator'], 403);
        }

        if (empty($project)) {
            return response()->json(['message' => "Post $id not found"], 404);
        }

        $data = $request->only(['name', 'description']);
        $result = $project->fill($data)->save();

        if ($result) {
            return response()->json(['message' => 'Project updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Project updated error'], 404);
        }
    }

}
