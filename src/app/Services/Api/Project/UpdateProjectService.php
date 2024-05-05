<?php


namespace App\Services\Api\Project;

use App\Http\Requests\Api\Project\UpdateProjectRequest;
use App\Models\Project;

class UpdateProjectService
{
    public $answer;

    public function updateProject($id, UpdateProjectRequest $request)
    {
        $project = Project::find($id);

        if (empty($project)) {
            $this->answer = response()->json(['message' => "Project $id not found"], 404);
            return;
        }

        if (auth()->user()->id !== $project->creator_id) {
            $this->answer = response()->json(['message' => 'Access closed, you are not creator'], 403);
            return;
        }

        $data = $request->only(['name', 'description']);
        $result = $project->fill($data)->save();

        if ($result) {
            $this->answer = response()->json(['message' => 'Project updated successfully'], 200);
        } else {
            $this->answer = response()->json(['message' => 'Project updated error'], 404);
        }
    }
}
