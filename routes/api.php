<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
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

Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', [UserController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/user/{id}', [UserController::class, 'getById'])->middleware(['auth:sanctum']);
Route::post('/user/create', [UserController::class, 'create']);
Route::patch('/user/edit', [UserController::class, 'edit'])->middleware(['auth:sanctum']);

Route::get('/status', [StatusController::class, 'getAll']);
Route::get('/status/{id}', [StatusController::class, 'getById']);
//Route::post('/status/create', [StatusController::class, 'create']);
//Route::patch('/status/edit', [StatusController::class, 'edit']);

Route::get('/projects', [ProjectController::class, 'getAll'])->middleware(['auth:sanctum']);
Route::get('/projects/{id}', [ProjectController::class, 'getById'])->middleware(['auth:sanctum']);
Route::post('/projects/create', [ProjectController::class, 'create'])->middleware(['auth:sanctum']);
Route::patch('/projects/edit', [ProjectController::class, 'edit'])->middleware(['auth:sanctum']);
Route::delete('/projects/{id}', [ProjectController::class, 'delete'])->middleware(['auth:sanctum']);

Route::get('/tasks', [TaskController::class, 'getAll'])->middleware(['auth:sanctum']);
Route::get('/tasks/{id}', [TaskController::class, 'getById'])->middleware(['auth:sanctum']);
Route::post('/tasks/create', [TaskController::class, 'create'])->middleware(['auth:sanctum']);
Route::patch('/tasks/edit', [TaskController::class, 'edit'])->middleware(['auth:sanctum']);
Route::delete('/tasks/{id}', [TaskController::class, 'delete'])->middleware(['auth:sanctum']);

