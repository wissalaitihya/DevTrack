@extends('layouts.app')

@section('content')

{{-- Header --}}
<div style="
    background:linear-gradient(135deg, #eff6ff, #f0f9ff);
    border-radius:16px; padding:25px 30px;
    margin-bottom:25px;
    display:flex; justify-content:space-between; align-items:center;
">
    <div>
        <h1 style="font-size:22px; font-weight:700; color:#1a1a2e; margin-bottom:6px;">
            Project: {{ $project->title }}
        </h1>
        <p style="font-size:13px; color:#64748b;">
            {{ $project->description ?? 'No description provided.' }}
        </p>
        <div style="display:flex; gap:15px; margin-top:10px; font-size:12px; color:#94a3b8;">
            <span>📅 Deadline: {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</span>
            <span>👥 {{ $project->members->count() }} members</span>
            <span>📋 {{ $project->tasks->count() }} tasks</span>
        </div>
    </div>
    <div style="display:flex; gap:10px;">
        @can('create', [App\Models\Task::class, $project])
            <a href="{{ route('projects.tasks.create', $project) }}" style="
                background:#3b82f6; color:white;
                padding:10px 20px; border-radius:10px;
                text-decoration:none; font-weight:600; font-size:14px;
            ">+ Add Task</a>
        @endcan
        <a href="{{ route('projects.index') }}" style="
            background:white; color:#64748b;
            padding:10px 20px; border-radius:10px;
            text-decoration:none; font-weight:600; font-size:14px;
            border:1.5px solid #e5e7eb;
        ">← Back</a>
    </div>
</div>

{{-- Stats --}}
@php
    $totalTasks    = $project->tasks->count();
    $todoTasks     = $project->tasks->where('status','todo');
    $progressTasks = $project->tasks->where('status','in_progress');
    $doneTasks     = $project->tasks->where('status','done');
    $pct           = $totalTasks > 0 ? round(($doneTasks->count()/$totalTasks)*100) : 0;
@endphp

<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:15px; margin-bottom:25px;">
    <div style="background:white; border-radius:12px; padding:16px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
        <p style="font-size:11px; color:#94a3b8; margin-bottom:5px;">Total</p>
        <h3 style="font-size:24px; font-weight:700; color:#1a1a2e;">{{ $totalTasks }}</h3>
    </div>
    <div style="background:#eff6ff; border-radius:12px; padding:16px; text-align:center;">
        <p style="font-size:11px; color:#3b82f6; margin-bottom:5px;">Todo</p>
        <h3 style="font-size:24px; font-weight:700; color:#2563eb;">{{ $todoTasks->count() }}</h3>
    </div>
    <div style="background:#fffbeb; border-radius:12px; padding:16px; text-align:center;">
        <p style="font-size:11px; color:#d97706; margin-bottom:5px;">In Progress</p>
        <h3 style="font-size:24px; font-weight:700; color:#d97706;">{{ $progressTasks->count() }}</h3>
    </div>
    <div style="background:#f0fdf4; border-radius:12px; padding:16px; text-align:center;">
        <p style="font-size:11px; color:#059669; margin-bottom:5px;">Done</p>
        <h3 style="font-size:24px; font-weight:700; color:#059669;">{{ $doneTasks->count() }}</h3>
    </div>
</div>

{{-- Progress --}}
<div style="background:white; border-radius:12px; padding:18px; margin-bottom:25px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
    <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:8px;">
        <span style="font-weight:600; color:#1a1a2e;">Overall Progress</span>
        <span style="color:#3b82f6; font-weight:600;">{{ $pct }}%</span>
    </div>
    <div style="background:#f1f5f9; border-radius:10px; height:8px;">
        <div style="background:#3b82f6; border-radius:10px; height:8px; width:{{ $pct }}%;"></div>
    </div>
</div>

{{-- Team Members --}}
<div style="background:white; border-radius:14px; padding:20px; margin-bottom:25px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
    <h3 style="font-size:14px; font-weight:600; color:#1a1a2e; margin-bottom:15px;">👥 Team Members</h3>
    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:15px;">
        @foreach($project->members as $member)
            <div style="display:flex; align-items:center; gap:8px; background:#f8fafc; padding:8px 14px; border-radius:25px;">
                <div style="
                    width:28px; height:28px; border-radius:50%;
                    background:{{ $member->pivot->role==='lead' ? '#7c3aed' : '#3b82f6' }};
                    color:white; font-size:11px; font-weight:600;
                    display:flex; align-items:center; justify-content:center;
                ">{{ strtoupper(substr($member->name,0,1)) }}</div>
                <span style="font-size:13px; font-weight:500;">{{ $member->name }}</span>
                <span style="
                    background:{{ $member->pivot->role==='lead' ? '#ede9fe' : '#dbeafe' }};
                    color:{{ $member->pivot->role==='lead' ? '#7c3aed' : '#2563eb' }};
                    padding:2px 8px; border-radius:20px; font-size:11px; font-weight:600;
                ">{{ ucfirst($member->pivot->role) }}</span>
                @can('manageMember', $project)
                    @if($member->id !== auth()->id())
                        <form action="{{ route('projects.members.remove',[$project,$member]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:13px;">✕</button>
                        </form>
                    @endif
                @endcan
            </div>
        @endforeach
    </div>

    @can('manageMember', $project)
        <form action="{{ route('projects.members.add',$project) }}" method="POST" style="display:flex; gap:10px;">
            @csrf
            <input type="email" name="email" placeholder="Add member by email..."
                   style="flex:1; padding:10px 15px; border:1.5px solid #e5e7eb; border-radius:10px; font-size:13px; outline:none; font-family:'Outfit',sans-serif;"
                   onfocus="this.style.borderColor='#3b82f6'"
                   onblur="this.style.borderColor='#e5e7eb'">
            <button type="submit" style="background:#3b82f6; color:white; padding:10px 20px; border-radius:10px; border:none; font-size:13px; font-weight:600; cursor:pointer; font-family:'Outfit',sans-serif;">
                + Add
            </button>
        </form>
    @endcan
</div>

{{-- Kanban Board --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">

    {{-- TODO --}}
    <div style="background:#dbeafe; border-radius:14px; padding:18px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <h3 style="font-size:14px; font-weight:600; color:#1e40af;">Todo</h3>
            <span style="background:#bfdbfe; color:#1d4ed8; padding:2px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                {{ $todoTasks->count() }}
            </span>
        </div>
        @forelse($todoTasks as $task)
            @include('projects.partials.task-card',['task'=>$task,'project'=>$project])
        @empty
            <p style="text-align:center; color:#93c5fd; font-size:13px; padding:20px 0;">No tasks</p>
        @endforelse
    </div>

    {{-- IN PROGRESS --}}
    <div style="background:#fef9c3; border-radius:14px; padding:18px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <h3 style="font-size:14px; font-weight:600; color:#92400e;">In Progress</h3>
            <span style="background:#fde68a; color:#d97706; padding:2px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                {{ $progressTasks->count() }}
            </span>
        </div>
        @forelse($progressTasks as $task)
            @include('projects.partials.task-card',['task'=>$task,'project'=>$project])
        @empty
            <p style="text-align:center; color:#fcd34d; font-size:13px; padding:20px 0;">No tasks</p>
        @endforelse
    </div>

    {{-- DONE --}}
    <div style="background:#dcfce7; border-radius:14px; padding:18px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
            <h3 style="font-size:14px; font-weight:600; color:#14532d;">Done</h3>
            <span style="background:#bbf7d0; color:#16a34a; padding:2px 10px; border-radius:20px; font-size:12px; font-weight:600;">
                {{ $doneTasks->count() }}
            </span>
        </div>
        @forelse($doneTasks as $task)
            @include('projects.partials.task-card',['task'=>$task,'project'=>$project])
        @empty
            <p style="text-align:center; color:#86efac; font-size:13px; padding:20px 0;">No tasks</p>
        @endforelse
    </div>

</div>

@endsection