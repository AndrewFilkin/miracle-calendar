<?php


namespace App\Services\Api\Task;


use App\Models\Task;

class DeleteTaskService
{
    public $answer;

    public function deleteTask($id)
    {
        $task = Task::find($id);

        if ($task) {
            if (auth()->user()->id == $task->creator_id || auth()->user()->role == 'admin') {
                $task->delete();
                $this->answer = response()->json(['message' => 'Task delete successfully'], 200);
                return;
            } else {
                $this->answer = response()->json(['message' => 'Access is closed, task delete can only be done by task creator or administrator'], 403);
                return;
            }
        } else {
            $this->answer = response()->json(['message' => "Task $id not found."], 404);
        }
    }
}
