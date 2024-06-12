<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;



Route::get('/', function () {
    phpinfo();
});

Route::get('search', function () {
    return view('search-user');
});
