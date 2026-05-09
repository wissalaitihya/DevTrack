@extends('layouts.app')

@section('content')

{{-- ─── PAGE HEADER ─────────────────────────────── --}}
<div class="page-header">
    <div>
        <h1 style="font-size:26px; font-weight:700; color:#1a1a2e;">
            Main Dashboard
        </h1>
        <p style="color:#888; font-size:13px; margin-top:4px;">
            📅 {{ now()->format('F d, Y') }}
        </p>
    </div>

    @can('create', App\Models\Project::class)
        <a href="{{ route('projects.create') }}" style="
            background:#3b82f6;
            color:white;
            padding:10px 22px;
            border-radius:10px;
            text-decoration:none;
            font-weight:600;
            font-size:14px;
        ">
            + New Project
        </a>
    @endcan
</div>

{{-- ─── STATS CARDS ─────────────────────────────── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:20px; margin-bottom:30px;">

    {{-- Active Projects --}}
    <div style="
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-radius:16px;
        padding:24px;
        color:white;
        position:relative;
        overflow:hidden;
    ">
        <p style="font-size:13px; opacity:0.85; margin-bottom:8px;">Active Projects</p>
        <h2 style="font-size:38px; font-weight:700;">{{ $totalProjects }}</h2>
        <div style="margin-top:12px; background:rgba(255,255,255,0.2); border-radius:10px; height:6px;">
            <div style="background:white; border-radius:10px; height:6px; width:70%;"></div>
        </div>
        <span style="position:absolute; right:20px; top:20px; font-size:28px; opacity:0.3;">📁</span>
    </div>

    {{-- Completed Tasks --}}
    <div style="
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-radius:16px;
        padding:24px;
        color:white;
        position:relative;
        overflow:hidden;
    ">
        <p style="font-size:13px; opacity:0.85; margin-bottom:8px;">Completed Tasks</p>
        <h2 style="font-size:38px; font-weight:700;">{{ $completedTasks }}</h2>
        <p style="font-size:12px; opacity:0.75; margin-top:8px;">
            Total : {{ $totalTasks }} tâches
        </p>
        <span style="position:absolute; right:20px; top:20px; font-size:28px; opacity:0.3;">✅</span>
    </div>

    {{-- Urgent Tasks --}}
    <div style="
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border-radius:16px;
        padding:24px;
        color:white;
        position:relative;
        overflow:hidden;
    ">
        <p style="font-size:13px; opacity:0.85; margin-bottom:8px;">Urgent Tasks</p>
        <h2 style="font-size:38px; font-weight:700;">{{ $urgentTasks }}</h2>
        <p style="font-size:12px; opacity:0.75; margin-top:8px;">
            Deadline dans moins de 48h
        </p>
        <span style="position:absolute; right:20px; top:20px; font-size:28px; opacity:0.3;">🔴</span>
    </div>

</div>

{{-- ─── RECENT TASKS ────────────────────────────── --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:30px;">

    {{-- Recent Tasks --}}
    <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
        <h3 style="font-size:16px; font-weight:600; margin-bottom:18px; color:#1a1a2e;">
            📋 Recent Tasks
        </h3>

        @php
            $recentTasks = $projects->flatMap->tasks->sortByDesc('created_at')->take(5);
        @endphp

        @if($recentTasks->isEmpty())
            <p style="color:#888; font-size:13px; text-align:center; padding:20px 0;">
                Aucune tâche pour le moment
            </p>
        @else
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="border-bottom:1px solid #f0f0f0;">
                        <th style="text-align:left; padding:8px 0; color:#888; font-weight:500;">Task</th>
                        <th style="text-align:left; padding:8px 0; color:#888; font-weight:500;">Project</th>
                        <th style="text-align:left; padding:8px 0; color:#888; font-weight:500;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTasks as $task)
                        <tr style="border-bottom:1px solid #f9f9f9;">
                            <td style="padding:10px 0; font-weight:500; color:#1a1a2e;">
                                {{ Str::limit($task->title, 20) }}
                            </td>
                            <td style="padding:10px 0; color:#666;">
                                {{ Str::limit($task->project->title ?? '', 15) }}
                            </td>
                            <td style="padding:10px 0;">
                                @if($task->status === 'todo')
                                    <span style="background:#f1f5f9; color:#64748b; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                        Todo
                                    </span>
                                @elseif($task->status === 'in_progress')
                                    <span style="background:#fef3c7; color:#d97706; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                        In Progress
                                    </span>
                                @else
                                    <span style="background:#d1fae5; color:#059669; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                        Done
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- My Projects --}}
    <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
        <h3 style="font-size:16px; font-weight:600; margin-bottom:18px; color:#1a1a2e;">
            📁 My Projects
        </h3>

        @if($projects->isEmpty())
            <p style="color:#888; font-size:13px; text-align:center; padding:20px 0;">
                Aucun projet pour le moment
            </p>
        @else
            @foreach($projects->take(4) as $project)
                @php
                    $done  = $project->tasks->where('status', 'done')->count();
                    $total = $project->tasks_count;
                    $pct   = $total > 0 ? round(($done / $total) * 100) : 0;
                    $role  = $project->members->find(auth()->id())?->pivot->role ?? 'member';
                @endphp

                <div style="margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid #f0f0f0;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <a href="{{ route('projects.show', $project) }}" style="font-weight:600; font-size:14px; color:#1a1a2e; text-decoration:none;">
                            {{ $project->title }}
                        </a>
                        <span style="
                            background:{{ $role === 'lead' ? '#ede9fe' : '#dbeafe' }};
                            color:{{ $role === 'lead' ? '#7c3aed' : '#2563eb' }};
                            padding:2px 10px;
                            border-radius:20px;
                            font-size:11px;
                            font-weight:600;
                        ">
                            {{ ucfirst($role) }}
                        </span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:12px; color:#888; margin-bottom:6px;">
                        <span>Progress: {{ $pct }}%</span>
                        <span>📅 {{ \Carbon\Carbon::parse($project->deadline)->format('M d') }}</span>
                    </div>
                    <div style="background:#f0f0f0; border-radius:10px; height:6px;">
                        <div style="background:#3b82f6; border-radius:10px; height:6px; width:{{ $pct }}%;"></div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>

{{-- ─── ALL PROJECTS GRID ───────────────────────── --}}
<div style="background:white; border-radius:16px; padding:24px; box-shadow:0 2px 10px rgba(0,0,0,0.06);">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 style="font-size:16px; font-weight:600; color:#1a1a2e;">🗂️ Project Directory</h3>
        <a href="{{ route('projects.archives') }}" style="font-size:13px; color:#3b82f6; text-decoration:none;">
            🗄️ Archives →
        </a>
    </div>

    @if($projects->isEmpty())
        <div style="text-align:center; padding:40px; color:#888;">
            <p style="font-size:16px; margin-bottom:15px;">Aucun projet pour le moment</p>
            <a href="{{ route('projects.create') }}" style="background:#3b82f6; color:white; padding:10px 22px; border-radius:10px; text-decoration:none; font-weight:600;">
                Créer votre premier projet
            </a>
        </div>
    @else
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:18px;">
            @foreach($projects as $project)
                @php
                    $done  = $project->tasks->where('status', 'done')->count();
                    $total = $project->tasks_count;
                    $pct   = $total > 0 ? round(($done / $total) * 100) : 0;
                    $role  = $project->members->find(auth()->id())?->pivot->role ?? 'member';
                    $urgent = $project->tasks->filter(fn($t) => $t->deadline_status === 'urgent')->count();
                @endphp

                <div style="
                    border:1.5px solid #f0f0f0;
                    border-radius:14px;
                    padding:18px;
                    transition:box-shadow 0.2s;
                    cursor:pointer;
                " onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'"
                   onmouseout="this.style.boxShadow='none'">

                    {{-- Header --}}
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;">
                        <h4 style="font-size:15px; font-weight:600; color:#1a1a2e; margin:0;">
                            {{ $project->title }}
                        </h4>
                        <span style="
                            background:{{ $role === 'lead' ? '#ede9fe' : '#dbeafe' }};
                            color:{{ $role === 'lead' ? '#7c3aed' : '#2563eb' }};
                            padding:3px 10px;
                            border-radius:20px;
                            font-size:11px;
                            font-weight:600;
                            white-space:nowrap;
                        ">
                            {{ ucfirst($role) }}
                        </span>
                    </div>

                    {{-- Description --}}
                    <p style="font-size:12px; color:#888; margin-bottom:12px; line-height:1.5;">
                        {{ Str::limit($project->description ?? 'Aucune description', 60) }}
                    </p>

                    {{-- Progress --}}
                    <div style="margin-bottom:12px;">
                        <div style="display:flex; justify-content:space-between; font-size:12px; color:#888; margin-bottom:5px;">
                            <span>Progress: {{ $pct }}%</span>
                            <span>{{ $done }}/{{ $total }} tasks</span>
                        </div>
                        <div style="background:#f0f0f0; border-radius:10px; height:6px;">
                            <div style="background:#3b82f6; border-radius:10px; height:6px; width:{{ $pct }}%;"></div>
                        </div>
                    </div>

                    {{-- Meta --}}
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; font-size:12px; color:#888;">
                        <span>📅 {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</span>
                        @if($urgent > 0)
                            <span style="color:#ef4444; font-weight:600;">🔴 {{ $urgent }} urgent</span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <a href="{{ route('projects.show', $project) }}" style="
                            background:#3b82f6; color:white;
                            padding:6px 14px; border-radius:8px;
                            text-decoration:none; font-size:12px; font-weight:600;
                        ">Voir</a>

                        @can('update', $project)
                            <a href="{{ route('projects.edit', $project) }}" style="
                                background:#fef3c7; color:#d97706;
                                padding:6px 14px; border-radius:8px;
                                text-decoration:none; font-size:12px; font-weight:600;
                            ">Modifier</a>
                        @endcan

                        @can('archive', $project)
                            <form action="{{ route('projects.archive', $project) }}" method="POST">
                                @csrf @method('PATCH')
                                <button style="
                                    background:#f1f5f9; color:#64748b;
                                    padding:6px 14px; border-radius:8px;
                                    border:none; font-size:12px; font-weight:600;
                                    cursor:pointer; font-family:'Outfit', sans-serif;
                                ">Archiver</button>
                            </form>
                        @endcan
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection