@extends('layouts.app')

@section('content')

<div style="max-width:650px; margin:0 auto;">

    <h1 style="font-size:22px; font-weight:700; color:#1a1a2e; margin-bottom:25px;">
        Create New Task
    </h1>

    <div style="background:white; border-radius:16px; padding:35px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">

        <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
            @csrf

            {{-- Row 1 : Project + Assignee --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">

                {{-- Project --}}
                <div>
                    <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                        Project
                    </label>
                    <div style="
                        padding:11px 15px;
                        border:1.5px solid #e5e7eb; border-radius:10px;
                        font-size:14px; background:#f8fafc; color:#64748b;
                    ">{{ $project->title }}</div>
                </div>

                {{-- Assignee --}}
                <div>
                    <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                        Assignee
                    </label>
                    <select name="assigned_to" style="
                        width:100%; padding:11px 15px;
                        border:1.5px solid #e5e7eb; border-radius:10px;
                        font-size:14px; outline:none;
                        font-family:'Outfit',sans-serif;
                        background:white; cursor:pointer;
                    "
                    onfocus="this.style.borderColor='#3b82f6'"
                    onblur="this.style.borderColor='#e5e7eb'">
                        <option value="">Select assignee...</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}"
                                {{ old('assigned_to') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} ({{ ucfirst($member->pivot->role) }})
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Row 2 : Priority + Status --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">

                {{-- Priority --}}
                <div>
                    <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                        Priority
                    </label>
                    <select name="priority" style="
                        width:100%; padding:11px 15px;
                        border:1.5px solid #e5e7eb; border-radius:10px;
                        font-size:14px; outline:none;
                        font-family:'Outfit',sans-serif;
                        background:white; cursor:pointer;
                    "
                    onfocus="this.style.borderColor='#3b82f6'"
                    onblur="this.style.borderColor='#e5e7eb'">
                        <option value="low"    {{ old('priority')==='low'    ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority')==='medium' ? 'selected' : '' }} selected>Medium</option>
                        <option value="high"   {{ old('priority')==='high'   ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                        Status
                    </label>
                    <select name="status" style="
                        width:100%; padding:11px 15px;
                        border:1.5px solid #e5e7eb; border-radius:10px;
                        font-size:14px; outline:none;
                        font-family:'Outfit',sans-serif;
                        background:white; cursor:pointer;
                    "
                    onfocus="this.style.borderColor='#3b82f6'"
                    onblur="this.style.borderColor='#e5e7eb'">
                        <option value="todo"        {{ old('status')==='todo'        ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ old('status')==='in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done"        {{ old('status')==='done'        ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

            </div>

            {{-- Title --}}
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                    Task Title
                </label>
                <input type="text" name="title"
                       value="{{ old('title') }}"
                       placeholder="Enter task title..."
                       style="
                           width:100%; padding:11px 15px;
                           border:1.5px solid #e5e7eb; border-radius:10px;
                           font-size:14px; outline:none;
                           font-family:'Outfit',sans-serif;
                           box-sizing:border-box;
                       "
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='#e5e7eb'">
                @error('title')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deadline --}}
            <div style="margin-bottom:20px;">
                <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                    Deadline
                </label>
                <input type="date" name="deadline"
                       value="{{ old('deadline') }}"
                       style="
                           width:100%; padding:11px 15px;
                           border:1.5px solid #e5e7eb; border-radius:10px;
                           font-size:14px; outline:none;
                           font-family:'Outfit',sans-serif;
                           box-sizing:border-box;
                       "
                       onfocus="this.style.borderColor='#3b82f6'"
                       onblur="this.style.borderColor='#e5e7eb'">
            </div>

            {{-- Description --}}
            <div style="margin-bottom:25px;">
                <label style="font-size:13px; font-weight:600; color:#374151; display:block; margin-bottom:7px;">
                    Description
                </label>
                <textarea name="description" rows="4"
                          placeholder="Enter task description..."
                          style="
                              width:100%; padding:11px 15px;
                              border:1.5px solid #e5e7eb; border-radius:10px;
                              font-size:14px; outline:none; resize:vertical;
                              font-family:'Outfit',sans-serif;
                              box-sizing:border-box;
                          "
                          onfocus="this.style.borderColor='#3b82f6'"
                          onblur="this.style.borderColor='#e5e7eb'">{{ old('description') }}</textarea>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <a href="{{ route('projects.show', $project) }}" style="
                    background:#f1f5f9; color:#64748b;
                    padding:11px 24px; border-radius:10px;
                    text-decoration:none; font-weight:600; font-size:14px;
                ">Cancel</a>
                <button type="submit" style="
                    background:#3b82f6; color:white;
                    padding:11px 24px; border-radius:10px;
                    border:none; font-weight:600; font-size:14px;
                    cursor:pointer; font-family:'Outfit',sans-serif;
                "
                onmouseover="this.style.background='#2563eb'"
                onmouseout="this.style.background='#3b82f6'">
                    Create Task
                </button>
            </div>

        </form>
    </div>
</div>

@endsection