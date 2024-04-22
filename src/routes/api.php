<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserRegisterController;
use App\Http\Controllers\Api\Admin\Auth\ApprovedUserRegisterController;
use App\Http\Middleware\Api\Admin\AdminIsValidMiddleware;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

/*
 * Register user without jwt token
 * After register admin have confirm user and create jwt
 */
Route::post('register', [UserRegisterController::class, 'register'])->name('auth.register');
Route::post('login', [UserRegisterController::class, 'login'])->name('auth.login');
Route::post('logout', [UserRegisterController::class, 'logout'])->name('auth.logout');


Route::middleware([AdminIsValidMiddleware::class])->prefix('admin')->group(function () {
    // Admin confirm user who registered
    Route::patch('confirm', [ApprovedUserRegisterController::class, 'approvedUserRegister']);
});


