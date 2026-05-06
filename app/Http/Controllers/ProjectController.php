<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // ✅ Dashboard — liste des projets
    public function index()
    {
        $projects = auth()->user()->projects()
                        ->with(['tasks', 'members'])
                        ->withCount('tasks')
                        ->get();

        return view('projects.index', compact('projects'));
    }

    // ✅ Formulaire créer projet
    public function create()
    {
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    // ✅ Sauvegarder nouveau projet
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        $project = Project::create($request->validated());

        // Ajouter le créateur comme lead
        $project->members()->attach(auth()->id(), ['role' => 'lead']);

        return redirect()->route('projects.index')
                         ->with('success', 'Projet créé avec succès !');
    }

    // ✅ Voir un projet et ses tâches
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $project->load(['tasks.assignee', 'members']);

        return view('projects.show', compact('project'));
    }

    // ✅ Formulaire modifier projet
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    // ✅ Sauvegarder modifications projet
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
                         ->with('success', 'Projet modifié avec succès !');
    }

    // ✅ Archiver un projet (soft delete)
    public function archive(Project $project)
    {
        $this->authorize('archive', $project);

        $project->delete(); // soft delete grâce au trait SoftDeletes

        return redirect()->route('projects.index')
                         ->with('success', 'Projet archivé !');
    }

    // ✅ Page archives
    public function archives()
    {
        $projects = auth()->user()->projects()
                        ->onlyTrashed()
                        ->with(['tasks', 'members'])
                        ->get();

        return view('projects.archives', compact('projects'));
    }

    // ✅ Restaurer un projet archivé
    public function restore($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $project);

        $project->restore();

        return redirect()->route('projects.archives')
                         ->with('success', 'Projet restauré !');
    }

    // ✅ BONUS — Supprimer définitivement
    public function forceDelete($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $project);

        $project->forceDelete();

        return redirect()->route('projects.archives')
                         ->with('success', 'Projet supprimé définitivement !');
    }
}