@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>➕ Nouveau Projet</h1>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
        Retour
    </a>
</div>

<div class="card">
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Titre *</label>
            <input type="text" 
                   name="title" 
                   class="form-control" 
                   value="{{ old('title') }}"
                   placeholder="Titre du projet">
            @error('title')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" 
                      class="form-control" 
                      rows="4"
                      placeholder="Description du projet">{{ old('description') }}</textarea>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Deadline *</label>
            <input type="date" 
                   name="deadline" 
                   class="form-control"
                   value="{{ old('deadline') }}">
            @error('deadline')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Créer le projet
        </button>
    </form>
</div>

@endsection