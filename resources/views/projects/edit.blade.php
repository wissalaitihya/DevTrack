@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>✏️ Modifier le Projet</h1>
    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
        Retour
    </a>
</div>

<div class="card">
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Titre *</label>
            <input type="text" 
                   name="title" 
                   class="form-control" 
                   value="{{ old('title', $project->title) }}">
            @error('title')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" 
                      class="form-control" 
                      rows="4">{{ old('description', $project->description) }}</textarea>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Deadline *</label>
            <input type="date" 
                   name="deadline" 
                   class="form-control"
                   value="{{ old('deadline', $project->deadline) }}">
            @error('deadline')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Sauvegarder
        </button>
    </form>
</div>

@endsection