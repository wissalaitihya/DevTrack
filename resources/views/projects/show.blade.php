@extends('layouts.app')

@section('content')

{{-- Header projet --}}
<div class="page-header">
    <h1>📁 {{ $project->title }}</h1>
    <div style="display:flex; gap:10px;">
        @can('create', [App\Models\Task::class, $project])
            <a href="{{ route('projects.tasks.create', $project) }}" 
               class="btn btn-primary">
                + Nouvelle Tâche
            </a>
        @endcan
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
            Retour
        </a>
    </div>
</div>

{{-- Infos projet --}}
<div class="card">
    <p>{{ $project->description ?? 'Aucune description' }}</p>
    <p style="margin-top:10px; color:#888; font-size:13px;">
        📅 Deadline : {{ \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') }}
    </p>
</div>

{{-- Membres du projet --}}
<div class="card">
    <div class="card-header">
        <h2 class="card-title">👥 Membres</h2>
    </div>

    <div class="members-list">
        @foreach($project->members as $member)
            <div class="member-item">
                <div class="member-avatar">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <span>{{ $member->name }}</span>
                <span class="badge {{ $member->pivot->role === 'lead' ? 'badge-high' : 'badge-todo' }}">
                    {{ $member->pivot->role }}
                </span>

                @can('manageMember', $project)
                    @if($member->id !== auth()->id())
                        <form action="{{ route('members.destroy', [$project, $member]) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">✕</button>
                        </form>
                    @endif
                @endcan
            </div>
        @endforeach
    </div>

    {{-- Ajouter membre --}}
    @can('manageMember', $project)
        <form action="{{ route('members.store', $project) }}" 
              method="POST"
              style="display:flex; gap:10px; margin-top:10px;">
            @csrf
            <input type="email" 
                   name="email" 
                   class="form-control" 
                   placeholder="Email du développeur"
                   style="max-width:300px;">
            <button type="submit" class="btn btn-primary">
                Ajouter
            </button>
        </form>
    @endcan
</div>

{{-- Liste des tâches --}}
<div class="card">
    <div class="card-header">
        <h2 class="card-title">📋 Tâches</h2>
    </div>

    @if($project->tasks->isEmpty())
        <div class="empty-state">
            <p>Aucune tâche pour ce projet</p>
        </div>
    @else
        <div class="task-list">
            @foreach($project->tasks as $task)
                <div class="task-item {{ $task->deadline_status }}">
                    <div class="task-info">
                        <h4>{{ $task->title }}</h4>
                        <p>
                            👤 {{ $task->assignee->name ?? 'Non assigné' }} |
                            📅 {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') : 'Pas de deadline' }} |
                            @if($task->deadline_status === 'urgent')
                                🔴 Urgent
                            @endif
                        </p>
                    </div>

                    <div class="task-actions">
                        {{-- Badge statut --}}
                        <span class="badge 
                            {{ $task->status === 'todo' ? 'badge-todo' : '' }}
                            {{ $task->status === 'in_progress' ? 'badge-progress' : '' }}
                            {{ $task->status === 'done' ? 'badge-done' : '' }}">
                            {{ $task->status_label }}
                        </span>

                        {{-- Badge priorité --}}
                        <span class="badge badge-{{ $task->priority }}">
                            {{ $task->priority }}
                        </span>

                        {{-- Changer statut — developer assigné --}}
                        @can('updateStatus', $task)
                            <form action="{{ route('tasks.updateStatus', $task) }}" 
                                  method="POST"
                                  style="display:flex; gap:5px;">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-control" 
                                        style="padding:4px 8px; font-size:12px;">
                                    <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>
                                        À faire
                                    </option>
                                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>
                                        En cours
                                    </option>
                                    <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>
                                        Terminé
                                    </option>
                                </select>
                                <button class="btn btn-primary btn-sm">OK</button>
                            </form>
                        @endcan

                        {{-- Modifier / Supprimer — lead --}}
                        @can('update', $task)
                            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" 
                               class="btn btn-warning btn-sm">
                                Modifier
                            </a>
                        @endcan

                        @can('delete', $task)
                            <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" 
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Supprimer
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection