<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'getById']);
Route::post('/user/create', [UserController::class, 'create']);
Route::patch('/user/edit', [UserController::class, 'edit']);

Route::get('/status', [StatusController::class, 'getAll']);
Route::get('/status/{id}', [StatusController::class, 'getById']);
Route::post('/status/create', [StatusController::class, 'create']);
Route::patch('/status/edit', [StatusController::class, 'edit']);

Route::get('/projects', [ProjectController::class, 'getAll']);
Route::get('/projects/{id}', [ProjectController::class, 'getById']);
Route::post('/projects/create', [ProjectController::class, 'create']);
Route::patch('/projects/edit', [ProjectController::class, 'edit']);
Route::delete('/projects/{id}', [ProjectController::class, 'delete']);

Route::get('/tasks', [TaskController::class, 'getAll']);
Route::get('/tasks/{id}', [TaskController::class, 'getById']);
Route::post('/tasks/create', [TaskController::class, 'create']);
Route::patch('/tasks/edit', [TaskController::class, 'edit']);
Route::delete('/tasks/{id}', [TaskController::class, 'delete']);

