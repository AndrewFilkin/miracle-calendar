<?php

namespace App\Http\Controllers\Api\Checklist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Checklist\CreateChecklistRequest;
use App\Http\Requests\Api\Checklist\UpdateChecklistRequest;
use App\Models\Task;
use App\Services\Api\Checklist\CreateChecklistService;
use function PHPUnit\Framework\isNull;

class ChecklistController extends Controller
{
    public function create(CreateChecklistRequest $request, CreateChecklistService $checklistService)
    {

        $data = $request->validated();

        $checklistService->createChecklist($data);

        return $checklistService->answer;
    }

    public function update(UpdateChecklistRequest $request)
    {
        $data = $request->validated();

        $task = Task::find($data['task_id']);

        if (auth()->user()->id == $task->creator_id || auth()->user()->role == 'admin') {

            $checklist = $task->checklists()->where('id', $data['checklist_id'])->first();

            if ($checklist == null) {
                return response()->json(['message' =>'checklist not found'], 404);
            }

            if ($checklist) {
                $checklist->is_selected = $data['is_selected'];

                if (array_key_exists('text', $data)) {
                    $checklist->text = $data['text'];
                }

                $checklist->save();

                return response()->json(['message' =>'checklist update'], 201);
            }
        } else {
            $this->answer = response()->json(['message' => 'Access is closed, checklist update can only be done by task creator or administrator'], 403);
        }
    }


}
