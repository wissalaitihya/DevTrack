<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::get('/projects/{project}/tasks', [TaskController::class, 'index']);