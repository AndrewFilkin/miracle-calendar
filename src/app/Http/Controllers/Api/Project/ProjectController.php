<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\CreateProjectRequest;
use App\Services\Api\Project\CreateProjectService;


class ProjectController extends Controller
{
    public function create(CreateProjectRequest $request, CreateProjectService $createProjectService)
    {
        $createProjectService->createProject($request);

        return $createProjectService->answer;
    }
}
