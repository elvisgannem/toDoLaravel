<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [TasksController::class, 'index'])->middleware(['auth'])->name('todolist.index');
Route::group(['prefix' => 'tasks', 'middleware' => 'auth'], function () {
    Route::get('/{id}/edit', [TasksController::class, 'edit'])->name('todolist.edit');
    Route::get('/{id}/add-users', [TasksController::class, 'addUsers'])->name('todolist.addUsers');
    Route::post('/create', [TasksController::class, 'store'])->name('todolist.store');
    Route::post('/add-user', [TasksController::class, 'addUserToTask'])->name('todolist.addUserToTask');
    Route::put('/update', [TasksController::class, 'update'])->name('todolist.update');
    Route::delete('/{id}', [TasksController::class, 'destroy'])->name('todolist.destroy');
    Route::delete('/{id}/{userId}', [TasksController::class, 'removeUserFromTask'])->name('todolist.edit.removeUser');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified', AdminMiddleware::class]], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
