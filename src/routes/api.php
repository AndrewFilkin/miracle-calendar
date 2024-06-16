<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserRegisterController;
use App\Http\Controllers\Api\Admin\Auth\ApprovedUserRegisterController;
use App\Http\Middleware\Api\Admin\AdminIsValidMiddleware;
use App\Http\Middleware\Api\IsApprovedMiddleware;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\Admin\UserShowController;
use App\Http\Controllers\Api\Admin\GenerateRegisterLinkController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\UserSearchController;
use App\Http\Controllers\Api\Admin\UserSortController;

/*
 * Register user without jwt token
 * After register admin have confirm user and create jwt
 */
Route::post('register/{code}', [UserRegisterController::class, 'register'])->name('auth.register');
Route::post('login', [UserRegisterController::class, 'login'])->name('auth.login');

Route::middleware([AdminIsValidMiddleware::class])->prefix('admin')->group(function () {

    Route::patch('approved', [ApprovedUserRegisterController::class, 'approvedUserRegister'])->name('admin.auth.approved');
    Route::delete('delete/user/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
    Route::post('update/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('search/approved/user', [UserSearchController::class, 'searchApprovedUsers'])->name('admin.search.approved.users');
    Route::get('search/not-approved/user', [UserSearchController::class, 'searchNotApprovedUsers'])->name('admin.search.not.approved.users');

    Route::post('generate-register-link', [GenerateRegisterLinkController::class, 'generate'])->name('auth.generate.link');

    Route::get('show-is-approved-users', [UserShowController::class, 'showIsApprovedUsers'])->name('show.is-approved');
    Route::get('show-is-not-approved-users', [UserShowController::class, 'showIsNotApprovedUsers'])->name('show.is-not-approved');

    Route::get('sort-asc-is-approved-user', [UserSortController::class, 'sortAscIsApprovedUser'])->name('sort.asc.is-approved.user');
    Route::get('sort-asc-is-not-approved-user', [UserSortController::class, 'sortAscIsNotApprovedUser'])->name('sort.asc.is-not-approved.user');
    Route::get('sort-desc-is-approved-user', [UserSortController::class, 'sortDescIsApprovedUser'])->name('sort.desc.is-approved.user');
    Route::get('sort-desc-is-not-approved-user', [UserSortController::class, 'sortDescIsNotApprovedUser'])->name('sort.desc.is-not-approved.user');
});

Route::middleware([IsApprovedMiddleware::class])->prefix('user')->group(function () {
    Route::post('logout', [UserRegisterController::class, 'logout'])->name('auth.logout');
});

Route::middleware([IsApprovedMiddleware::class])->prefix('task')->group(function () {

    Route::get('show', [TaskController::class, 'showTask'])->name('show.task');

    Route::get('show-user', [TaskController::class, 'showUser'])->name('task.show.user');
    Route::get('search-user', [TaskController::class, 'searchUser'])->name('task.search.user');

    Route::post('create', [TaskController::class, 'create'])->name('task.create');
    Route::patch('update/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('delete/{id}', [TaskController::class, 'delete'])->name('task.delete');
});

Route::middleware([IsApprovedMiddleware::class])->prefix('comment')->group(function () {
    Route::post('create', [CommentController::class, 'create'])->name('comment.create');
    Route::patch('update/{id}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
});
