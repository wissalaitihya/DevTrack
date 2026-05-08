@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>✏️ Modifier la Tâche</h1>
    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
        Retour
    </a>
</div>

<div class="card">
    <form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Titre *</label>
            <input type="text" 
                   name="title" 
                   class="form-control"
                   value="{{ old('title', $task->title) }}">
            @error('title')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" 
                      class="form-control" 
                      rows="3">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Priorité *</label>
            <select name="priority" class="form-control">
                <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>
                    🟢 Faible
                </option>
                <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>
                    🟡 Moyenne
                </option>
                <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>
                    🔴 Haute
                </option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Deadline *</label>
            <input type="date" 
                   name="deadline" 
                   class="form-control"
                   value="{{ old('deadline', $task->deadline) }}">
            @error('deadline')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Assigner à *</label>
            <select name="assigned_to" class="form-control">
                @foreach($members as $member)
                    <option value="{{ $member->id }}"
                            {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>
                        {{ $member->name }} ({{ $member->pivot->role }})
                    </option>
                @endforeach
            </select>
            @error('assigned_to')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Sauvegarder
        </button>
    </form>
</div>

@endsection