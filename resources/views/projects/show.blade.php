@extends('layouts.app')

@section('content')

{{-- ─── HEADER ──────────────────────────────────── --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <div>
        <h1 style="font-size:24px; font-weight:700; color:#1a1a2e;">
            📁 {{ $project->title }}
        </h1>
        <p style="color:#888; font-size:13px; margin-top:4px;">
            📅 Deadline : {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
        </p>
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
            background:#f1f5f9; color:#64748b;
            padding:10px 20px; border-radius:10px;
            text-decoration:none; font-weight:600; font-size:14px;
        ">← Back</a>
    </div>
</div>

{{-- ─── STATS PROJET ────────────────────────────── --}}
@php
    $totalTasks     = $project->tasks->count();
    $todoTasks      = $project->tasks->where('status', 'todo');
    $progressTasks  = $project->tasks->where('status', 'in_progress');
    $doneTasks      = $project->tasks->where('status', 'done');
    $pct            = $totalTasks > 0 ? round(($doneTasks->count() / $totalTasks) * 100) : 0;
@endphp

<div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:15px; margin-bottom:25px;">

    <div style="background:white; border-radius:14px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,0.05); text-align:center;">
        <p style="color:#888; font-size:12px; margin-bottom:6px;">Total Tasks</p>
        <h3 style="font-size:28px; font-weight:700; color:#1a1a2e;">{{ $totalTasks }}</h3>
    </div>

    <div style="background:white; border-radius:14px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,0.05); text-align:center;">
        <p style="color:#888; font-size:12px; margin-bottom:6px;">Todo</p>
        <h3 style="font-size:28px; font-weight:700; color:#64748b;">{{ $todoTasks->count() }}</h3>
    </div>

    <div style="background:white; border-radius:14px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,0.05); text-align:center;">
        <p style="color:#888; font-size:12px; margin-bottom:6px;">In Progress</p>
        <h3 style="font-size:28px; font-weight:700; color:#d97706;">{{ $progressTasks->count() }}</h3>
    </div>

    <div style="background:white; border-radius:14px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,0.05); text-align:center;">
        <p style="color:#888; font-size:12px; margin-bottom:6px;">Done</p>
        <h3 style="font-size:28px; font-weight:700; color:#059669;">{{ $doneTasks->count() }}</h3>
    </div>

</div>

{{-- Progress Bar --}}
<div style="background:white; border-radius:14px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,0.05); margin-bottom:25px;">
    <div style="display:flex; justify-content:space-between; font-size:13px; color:#888; margin-bottom:8px;">
        <span>Project Progress</span>
        <span style="font-weight:600; color:#3b82f6;">{{ $pct }}%</span>
    </div>
    <div style="background:#f0f0f0; border-radius:10px; height:8px;">
        <div style="background:#3b82f6; border-radius:10px; height:8px; width:{{ $pct }}%; transition:width 0.3s;"></div>
    </div>
</div>

{{-- ─── MEMBRES ─────────────────────────────────── --}}
<div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05); margin-bottom:25px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
        <h3 style="font-size:15px; font-weight:600; color:#1a1a2e;">👥 Team Members</h3>
    </div>

    <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:15px;">
        @foreach($project->members as $member)
            <div style="
                display:flex; align-items:center; gap:8px;
                background:#f8fafc; border-radius:25px;
                padding:8px 14px; font-size:13px;
            ">
                <div style="
                    width:30px; height:30px; border-radius:50%;
                    background:{{ $member->pivot->role === 'lead' ? '#7c3aed' : '#3b82f6' }};
                    color:white; display:flex; align-items:center;
                    justify-content:center; font-size:13px; font-weight:600;
                ">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <span style="font-weight:500; color:#1a1a2e;">{{ $member->name }}</span>
                <span style="
                    background:{{ $member->pivot->role === 'lead' ? '#ede9fe' : '#dbeafe' }};
                    color:{{ $member->pivot->role === 'lead' ? '#7c3aed' : '#2563eb' }};
                    padding:2px 8px; border-radius:20px; font-size:11px; font-weight:600;
                ">{{ ucfirst($member->pivot->role) }}</span>

                @can('manageMember', $project)
                    @if($member->id !== auth()->id())
                        <form action="{{ route('projects.members.remove', [$project, $member]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button style="
                                background:none; border:none; color:#ef4444;
                                cursor:pointer; font-size:14px; padding:0;
                            ">✕</button>
                        </form>
                    @endif
                @endcan
            </div>
        @endforeach
    </div>

    {{-- Ajouter membre --}}
    @can('manageMember', $project)
        <form action="{{ route('projects.members.add', $project) }}" method="POST"
              style="display:flex; gap:10px;">
            @csrf
            <input type="email" name="email"
                   placeholder="Email du développeur"
                   style="
                       flex:1; padding:10px 15px;
                       border:1.5px solid #e5e7eb; border-radius:10px;
                       font-size:13px; outline:none;
                       font-family:'Outfit', sans-serif;
                   "
                   onfocus="this.style.borderColor='#3b82f6'"
                   onblur="this.style.borderColor='#e5e7eb'">
            <button type="submit" style="
                background:#3b82f6; color:white;
                padding:10px 20px; border-radius:10px;
                border:none; font-size:13px; font-weight:600;
                cursor:pointer; font-family:'Outfit', sans-serif;
            ">+ Add</button>
        </form>
    @endcan
</div>

{{-- ─── KANBAN BOARD ────────────────────────────── --}}
<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px;">

    {{-- ── COLONNE TODO ──────────────────────────── --}}
    <div style="background:#f0f9ff; border-radius:14px; padding:18px;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
            <div style="width:10px; height:10px; border-radius:50%; background:#94a3b8;"></div>
            <h3 style="font-size:14px; font-weight:600; color:#1a1a2e;">Todo</h3>
            <span style="
                background:#e2e8f0; color:#64748b;
                padding:2px 8px; border-radius:20px; font-size:12px;
                margin-left:auto;
            ">{{ $todoTasks->count() }}</span>
        </div>

        @forelse($todoTasks as $task)
            @include('projects.partials.task-card', ['task' => $task, 'project' => $project])
        @empty
            <p style="text-align:center; color:#94a3b8; font-size:13px; padding:20px 0;">
                No tasks
            </p>
        @endforelse
    </div>

    {{-- ── COLONNE IN PROGRESS ───────────────────── --}}
    <div style="background:#fffbeb; border-radius:14px; padding:18px;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
            <div style="width:10px; height:10px; border-radius:50%; background:#f59e0b;"></div>
            <h3 style="font-size:14px; font-weight:600; color:#1a1a2e;">In Progress</h3>
            <span style="
                background:#fef3c7; color:#d97706;
                padding:2px 8px; border-radius:20px; font-size:12px;
                margin-left:auto;
            ">{{ $progressTasks->count() }}</span>
        </div>

        @forelse($progressTasks as $task)
            @include('projects.partials.task-card', ['task' => $task, 'project' => $project])
        @empty
            <p style="text-align:center; color:#94a3b8; font-size:13px; padding:20px 0;">
                No tasks
            </p>
        @endforelse
    </div>

    {{-- ── COLONNE DONE ──────────────────────────── --}}
    <div style="background:#f0fdf4; border-radius:14px; padding:18px;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
            <div style="width:10px; height:10px; border-radius:50%; background:#22c55e;"></div>
            <h3 style="font-size:14px; font-weight:600; color:#1a1a2e;">Done</h3>
            <span style="
                background:#dcfce7; color:#16a34a;
                padding:2px 8px; border-radius:20px; font-size:12px;
                margin-left:auto;
            ">{{ $doneTasks->count() }}</span>
        </div>

        @forelse($doneTasks as $task)
            @include('projects.partials.task-card', ['task' => $task, 'project' => $project])
        @empty
            <p style="text-align:center; color:#94a3b8; font-size:13px; padding:20px 0;">
                No tasks
            </p>
        @endforelse
    </div>

</div>

@endsection