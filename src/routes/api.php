<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserRegisterController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

/*
 * Register user without jwt token
 * After register admin have confirm user and create jwt
 */
Route::post('register', [UserRegisterController::class, 'register'])->name('auth.register');
