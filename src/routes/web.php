<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Task;
use App\Models\Comment;


Route::get('/', function () {
    $user = User::find(1);

    foreach ($user->comments as $comment) {
        echo $comment . '<br>';
    }
});
