<?php

use Illuminate\Support\Facades\Route;
use Modules\Task\Http\Controllers\TaskController;

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
    Route::resource('task', TaskController::class)->names('task')->middleware('isAdmin');
});

Route::post('/add-task/{parentId}', [TaskController::class, 'store'])->middleware('isAdmin');
Route::get('/add-task/{parentId}', [TaskController::class, 'create'])->middleware('isAdmin');
Route::put('/edit-task/{id}', [TaskController::class, 'update'])->name('task.update')->middleware('isAdmin');
Route::delete('/delete-task/{id}', [TaskController::class, 'destroy'])->name('task.destroy')->middleware('isAdmin');
Route::get('/add-assignee/{id}', [TaskController::class, 'addAssignee'])->name('task.add-assignee')->middleware('isAdmin');
Route::post('/add-assignee/{id}', [TaskController::class, 'storeAssignee'])->name('task.store-assignee')->middleware('isAdmin');


// send email
Route::get('/send-email', [TaskController::class, 'sendEmail']);
