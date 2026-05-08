<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;

class TaskController extends Controller
{
    // ✅ Formulaire créer tâche
    public function create(Project $project)
    {
        $this->authorize('create', [Task::class, $project]);

        // Uniquement les membres du projet
        $members = $project->members()->get();

        return view('tasks.create', compact('project', 'members'));
    }

    // ✅ Sauvegarder nouvelle tâche
    public function store(StoreTaskRequest $request, Project $project)
    {
        $this->authorize('create', [Task::class, $project]);

        $project->tasks()->create($request->validated());

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Tâche créée avec succès !');
    }

    // ✅ Formulaire modifier tâche
    public function edit(Project $project, Task $task)
    {
        $this->authorize('update', $task);

        $members = $project->members()->get();

        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    // ✅ Sauvegarder modifications tâche
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Tâche modifiée avec succès !');
    }

    // ✅ Changer uniquement le statut (developer assigné)
    public function updateStatus(UpdateTaskStatusRequest $request, Project $project, Task $task)
    {
        $this->authorize('updateStatus', $task);

        $task->update(['status' => $request->status]);

        return redirect()->route('projects.show', $project) 
                         ->with('success', 'Statut mis à jour !');
    }

    // ✅ Supprimer une tâche
    public function destroy(Project $project, Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Tâche supprimée !');
    }
}