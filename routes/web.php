<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->to('/tasks');
});

Route::resource('tasks', TaskController::class);
Route::put('tasks/{task}/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
