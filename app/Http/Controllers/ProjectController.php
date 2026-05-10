<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
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

    // ✅ Stats pour le dashboard
    $totalProjects    = $projects->count();
    $totalTasks       = $projects->sum('tasks_count');
    $completedTasks   = $projects->flatMap->tasks->where('status', 'done')->count();
    $urgentTasks      = $projects->flatMap->tasks
                                ->filter(fn($t) => $t->deadline_status === 'urgent')
                                ->count();

    return view('projects.index', compact(
        'projects',
        'totalProjects',
        'totalTasks',
        'completedTasks',
        'urgentTasks'
    ));
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

        // ✅ Users disponibles = tous les users SAUF membres déjà dans le projet
        $availableUsers = \App\Models\User::whereNotIn('id', 
            $project->members->pluck('id')
        )->get();

        return view('projects.show', compact('project', 'availableUsers'));
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
    public function destroy(Project $project)
    {
        $this->authorize('archive', $project);

        $project->delete();

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

    // ✅ Ajouter un membre par email
    public function addMember(Request $request, Project $project)
    {
        $this->authorize('manageMember', $project);

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Vérifier pas déjà membre
        if ($project->members()->where('user_id', $request->user_id)->exists()) {
            return redirect()->back()->with('error', 'Utilisateur déjà membre !');
        }

        $project->members()->attach($request->user_id, ['role' => 'developer']);

        return redirect()->back()->with('success', 'Membre ajouté avec succès !');
    }

    // ✅ Retirer un membre
    public function removeMember(Project $project, User $user)
    {
        $this->authorize('manageMember', $project);

        // Empêcher le lead de se retirer lui-même
        if ($user->id === auth()->id()) {
            return redirect()->back()
                             ->with('error', 'Vous ne pouvez pas vous retirer vous-même !');
        }

        $project->members()->detach($user->id);

        return redirect()->back()
                         ->with('success', 'Membre retiré avec succès !');
    }
}