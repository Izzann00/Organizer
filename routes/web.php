<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('projects.index');
});

    Route::get('/login', [AuthController::class, 'showLogin']) ->name('login');

    Route::post('/login', [AuthController::class, 'login']) ->name('login.store');

    Route::post('/logout', [AuthController::class, 'logout']) ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/categories', [CategoryController::class, 'index']) ->name('categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create']) ->name('categories.create');

    Route::post('/categories', [CategoryController::class, 'store']) ->name('categories.store');

    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']) ->name('categories.edit');

    Route::post('/categories/{id}', [CategoryController::class, 'update']) ->name('categories.update');

    Route::post('/categories/{id}/delete', [CategoryController::class, 'destroy']) ->name('categories.destroy');

    Route::get('/users', [UserController::class, 'index']) ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create']) ->name('users.create');

    Route::post('/users', [UserController::class, 'store']) ->name('users.store');

    Route::get('/users/{id}/edit', [UserController::class, 'edit']) ->name('users.edit');

    Route::post('/users/{id}', [UserController::class, 'update']) ->name('users.update');

    Route::post('/users/{id}/delete', [UserController::class, 'destroy']) ->name('users.destroy');

    Route::get('/projects', [ProjectController::class, 'index']) ->name('projects.index');

    Route::get('/projects/create', [ProjectController::class, 'create']) ->name('projects.create');

    Route::post('/projects', [ProjectController::class, 'store']) ->name('projects.store');

    Route::get('/projects/{id}', [ProjectController::class, 'show']) ->name('projects.show');

    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit']) ->name('projects.edit');

    Route::post('/projects/{id}', [ProjectController::class, 'update']) ->name('projects.update');

    Route::post('/projects/{id}/users', [ProjectController::class, 'addUser']) ->name('projects.users.add');

    Route::post('/projects/{id}/users/{userId}/delete', [ProjectController::class, 'removeUser']) ->name('projects.users.remove');

    Route::get('/projects/{projectId}/tasks/create', [TaskController::class, 'create']) ->name('tasks.create');

    Route::post('/projects/{projectId}/tasks', [TaskController::class, 'store']) ->name('tasks.store');

    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit']) ->name('tasks.edit');

    Route::post('/tasks/{id}', [TaskController::class, 'update']) ->name('tasks.update');

    Route::post('/tasks/{id}/delete', [TaskController::class, 'destroy']) ->name('tasks.destroy');

});

