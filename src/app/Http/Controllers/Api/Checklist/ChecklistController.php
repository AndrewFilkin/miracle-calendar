<?php

namespace App\Http\Controllers\Api\Checklist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Checklist\CreateChecklistRequest;
use App\Services\Api\Checklist\CreateChecklistService;

class ChecklistController extends Controller
{
    public function create(CreateChecklistRequest $request, CreateChecklistService $checklistService) {

        $data = $request->validated();

        $checklistService->createChecklist($data);

        return $checklistService->answer;
    }
}
