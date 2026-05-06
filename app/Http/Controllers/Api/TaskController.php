<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    // ✅ GET /api/projects/{project}/tasks
    public function index(Project $project)
    {
        $tasks = $project->tasks()
                         ->with('assignee')
                         ->get();

        return TaskResource::collection($tasks);
    }
}