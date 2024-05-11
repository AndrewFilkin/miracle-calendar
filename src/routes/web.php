<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;



Route::get('/', function () {
    phpinfo();
});

Route::post('/create-test', function (\Illuminate\Http\Request $request) {

    $mas = [];

    foreach ($request->file('files') as $file) {
        $mas[] = $file->getClientOriginalName();
    }
    return response()->json(['mas' => $mas], 200);

})->name('test.upload');
