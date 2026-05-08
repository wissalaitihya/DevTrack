@extends('layouts.app')

@section('title', 'Create Task')

@section('topbar-action')
    <a href="{{ route('projects.show', $project) }}"
        class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
        <i class="bi bi-arrow-left"></i> Back to Project
    </a>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="bg-white rounded-3 p-4" style="border:1px solid #e2e8f0;">

            <h5 class="mb-1" style="font-size:18px; font-weight:700;">New Task</h5>
            <p class="text-muted mb-4" style="font-size:13px;">
                Project: <strong>{{ $project->title }}</strong>
            </p>

            <form action="{{ route('tasks.store', $project) }}" method="POST">
                @csrf

                {{-- TITLE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="Enter task title...">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Enter task description...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ASSIGNED TO --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Assign To <span class="text-danger">*</span></label>
                    <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
                        <option value="">Select a developer</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}"
                                {{ old('assigned_to') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }}
                                ({{ $member->pivot->role }})
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- PRIORITY --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                    <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }} selected>🟡 Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🔴 High</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- DEADLINE --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}"
                        class="form-control @error('deadline') is-invalid @enderror">
                    @error('deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- BUTTONS --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white px-4"
                        style="background:#6366f1; border-radius:8px;">
                        <i class="bi bi-plus-circle me-1"></i> Create Task
                    </button>
                    <a href="{{ route('projects.show', $project) }}"
                        class="btn btn-outline-secondary px-4" style="border-radius:8px;">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection