<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\CreateProjectRequest;
use App\Http\Requests\Api\Project\UpdateProjectRequest;
use App\Services\Api\Project\CreateProjectService;
use App\Services\Api\Project\UpdateProjectService;

class ProjectController extends Controller
{
    public function create(CreateProjectRequest $request, CreateProjectService $createProjectService)
    {
        $createProjectService->createProject($request);

        return $createProjectService->answer;
    }

    public function update($id, UpdateProjectRequest $request, UpdateProjectService $updateProjectService)
    {
        $updateProjectService->updateProject($id, $request);

        return $updateProjectService->answer;

    }

}
