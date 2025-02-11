<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('user', UserController::class)->names('user')->middleware('auth');
});

Route::get('/user-task', [UserController::class, 'index'])->name('user-task.index')->middleware('auth');
Route::put('/user-task/{id}', [UserController::class, 'update'])->name('user-task.update')->middleware('auth');
