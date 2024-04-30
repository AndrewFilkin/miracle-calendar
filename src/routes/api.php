<?php

use App\Http\Controllers\Api\Project\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserRegisterController;
use App\Http\Controllers\Api\Admin\Auth\ApprovedUserRegisterController;
use App\Http\Middleware\Api\Admin\AdminIsValidMiddleware;
use App\Http\Middleware\Api\IsApprovedMiddleware;

/*
 * Register user without jwt token
 * After register admin have confirm user and create jwt
 */
Route::post('register', [UserRegisterController::class, 'register'])->name('auth.register');
Route::post('login', [UserRegisterController::class, 'login'])->name('auth.login');
Route::post('logout', [UserRegisterController::class, 'logout'])->name('auth.logout');
Route::post('update', [UserRegisterController::class, 'update'])->name('auth.update');


Route::middleware([AdminIsValidMiddleware::class])->prefix('admin')->group(function () {
    // Admin confirm user who registered
    Route::patch('approved', [ApprovedUserRegisterController::class, 'approvedUserRegister']);
});


Route::middleware([IsApprovedMiddleware::class])->prefix('project')->group(function () {
    Route::post('create', [ProjectController::class, 'create'])->name('project.create');
});

