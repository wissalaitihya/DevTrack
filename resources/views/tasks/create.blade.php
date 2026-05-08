@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>➕ Nouvelle Tâche</h1>
    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
        Retour
    </a>
</div>

<div class="card">
    <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Titre *</label>
            <input type="text" 
                   name="title" 
                   class="form-control"
                   value="{{ old('title') }}"
                   placeholder="Titre de la tâche">
            @error('title')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" 
                      class="form-control" 
                      rows="3"
                      placeholder="Description de la tâche">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Priorité *</label>
            <select name="priority" class="form-control">
                <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>
                    🟢 Faible
                </option>
                <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>
                    🟡 Moyenne
                </option>
                <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>
                    🔴 Haute
                </option>
            </select>
            @error('priority')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Statut *</label>
            <select name="status" class="form-control">
                <option value="todo">À faire</option>
                <option value="in_progress">En cours</option>
                <option value="done">Terminé</option>
            </select>
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

        <div class="form-group">
            <label class="form-label">Assigner à *</label>
            <select name="assigned_to" class="form-control">
                <option value="">-- Choisir un développeur --</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" 
                            {{ old('assigned_to') == $member->id ? 'selected' : '' }}>
                        {{ $member->name }} ({{ $member->pivot->role }})
                    </option>
                @endforeach
            </select>
            @error('assigned_to')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Créer la tâche
        </button>
    </form>
</div>

@endsection