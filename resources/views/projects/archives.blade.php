@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>🗄️ Archives</h1>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
        Retour au Dashboard
    </a>
</div>

@if($projects->isEmpty())
    <div class="empty-state">
        <p>Aucun projet archivé</p>
    </div>
@else
    <div class="projects-grid">
        @foreach($projects as $project)
            <div class="project-card" style="border-left-color: #888;">
                <h3>{{ $project->title }}</h3>
                <p>{{ $project->description ?? 'Aucune description' }}</p>
                <p style="font-size:12px; color:#888;">
                    🗑️ Archivé le : {{ \Carbon\Carbon::parse($project->deleted_at)->format('d/m/Y') }}
                </p>

                <div class="project-actions" style="margin-top:15px;">
                    @can('restore', $project)
                        <form action="{{ route('projects.restore', $project->id) }}" 
                              method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">
                                Restaurer
                            </button>
                        </form>
                    @endcan

                    @can('forceDelete', $project)
                        <form action="{{ route('projects.forceDelete', $project->id) }}" 
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Supprimer définitivement ?')">
                                Supprimer définitivement
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection