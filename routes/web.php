<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->to('/tasks');
});

Route::put('tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
Route::resource('tasks', TaskController::class);
