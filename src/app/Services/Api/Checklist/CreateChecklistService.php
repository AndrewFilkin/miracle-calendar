<?php


namespace App\Services\Api\Checklist;


use App\Models\Checklist;
use App\Models\Task;

class CreateChecklistService
{

    public $answer;

    public function createChecklist(array $data)
    {

        $creator = auth()->user()->id;

        $task = Task::find($data['task_id']);

        // Access close if not creator or admin
        if ($task->creator_id == $creator || auth()->user()->role == 'admin') {

            foreach ($data['text'] as $index => $text) {
                $isSelected = $data['is_selected'][$index];

                // Сохраняем данные в базу
                Checklist::create([
                    'user_id' => $creator,
                    'task_id' => $data['task_id'],
                    'text' => $text,
                    'is_selected' => $isSelected
                ]);
            }
            $this->answer = response()->json(['message' => 'Check list created success'], 201);
        } else {
            $this->answer = response()->json(['message' => 'Access close'], 403);;
        }
    }
}
