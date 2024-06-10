<?php

use App\Http\Controllers\Api\Project\ProjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserRegisterController;
use App\Http\Controllers\Api\Admin\Auth\ApprovedUserRegisterController;
use App\Http\Middleware\Api\Admin\AdminIsValidMiddleware;
use App\Http\Middleware\Api\IsApprovedMiddleware;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\Admin\UserShowController;
use App\Http\Controllers\Api\Admin\GenerateRegisterLinkController;

/*
 * Register user without jwt token
 * After register admin have confirm user and create jwt
 */
Route::post('register/{code}', [UserRegisterController::class, 'register'])->name('auth.register');
Route::post('login', [UserRegisterController::class, 'login'])->name('auth.login');

Route::middleware([AdminIsValidMiddleware::class])->prefix('admin')->group(function () {

    Route::patch('approved', [ApprovedUserRegisterController::class, 'approvedUserRegister'])->name('admin.auth.approved');
    Route::delete('delete/{id}', [ApprovedUserRegisterController::class, 'delete'])->name('admin.auth.delete');

    Route::post('generate-register-link', [GenerateRegisterLinkController::class, 'generate'])->name('auth.generate.link');

    Route::get('show-is-approved-users', [UserShowController::class, 'showIsApprovedUsers'])->name('show.is-approved');
    Route::get('show-is-not-approved-users', [UserShowController::class, 'showIsNotApprovedUsers'])->name('show.is-not-approved');
});

Route::middleware([IsApprovedMiddleware::class])->prefix('user')->group(function () {
    Route::post('logout', [UserRegisterController::class, 'logout'])->name('auth.logout');
    Route::post('update', [UserRegisterController::class, 'update'])->name('auth.update');
});

Route::middleware([IsApprovedMiddleware::class])->prefix('project')->group(function () {
    Route::post('create', [ProjectController::class, 'create'])->name('project.create');
    Route::patch('update/{id}', [ProjectController::class, 'update'])->name('project.update');
});

Route::middleware([IsApprovedMiddleware::class])->prefix('task')->group(function () {
    Route::post('create', [TaskController::class, 'create'])->name('task.create');
    Route::patch('update/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('delete/{id}', [TaskController::class, 'delete'])->name('task.delete');
});

Route::middleware([IsApprovedMiddleware::class])->prefix('comment')->group(function () {
    Route::post('create', [CommentController::class, 'create'])->name('comment.create');
    Route::patch('update/{id}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
});
