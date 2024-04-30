<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Project;


Route::get('/', function () {
    $project = Project::find(1);

    foreach ($project->tasks as $task) {
        echo $task . '<br>';
    }
});
