@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>📁 Mes Projets</h1>
    @can('create', App\Models\Project::class)
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            + Nouveau Projet
        </a>
    @endcan
</div>

@if($projects->isEmpty())
    <div class="empty-state">
        <p>Aucun projet pour le moment</p>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">
            Créer votre premier projet
        </a>
    </div>
@else
    <div class="projects-grid">
        @foreach($projects as $project)
            <div class="project-card">
                <h3>{{ $project->title }}</h3>
                <p>{{ $project->description ?? 'Aucune description' }}</p>

                <div class="project-meta">
                    <span>📅 {{ \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') }}</span>
                    <span>✅ {{ $project->tasks->where('status', 'done')->count() }} / {{ $project->tasks_count }} tâches</span>
                </div>

                <div class="project-actions">
                    <a href="{{ route('projects.show', $project) }}" 
                       class="btn btn-primary btn-sm">
                        Voir
                    </a>

                    @can('update', $project)
                        <a href="{{ route('projects.edit', $project) }}" 
                           class="btn btn-warning btn-sm">
                            Modifier
                        </a>
                    @endcan

                    @can('archive', $project)
                        <form action="{{ route('projects.archive', $project) }}" 
                              method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-secondary btn-sm">
                                Archiver
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection