@extends('layouts.app')

@section('content')

{{-- Header --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <h1 style="font-size:22px; font-weight:700; color:#1a1a2e;">Project Directory</h1>
    @can('create', App\Models\Project::class)
        <a href="{{ route('projects.create') }}" style="
            background:#3b82f6; color:white;
            padding:10px 22px; border-radius:10px;
            text-decoration:none; font-weight:600; font-size:14px;
            display:flex; align-items:center; gap:8px;
        ">+ New Project</a>
    @endcan
</div>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:15px; margin-bottom:25px;">
    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
        <p style="font-size:12px; color:#94a3b8; margin-bottom:6px;">Total Projects</p>
        <h3 style="font-size:28px; font-weight:700; color:#1a1a2e;">{{ $totalProjects }}</h3>
    </div>
    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
        <p style="font-size:12px; color:#94a3b8; margin-bottom:6px;">Completed Tasks</p>
        <h3 style="font-size:28px; font-weight:700; color:#059669;">{{ $completedTasks }}</h3>
    </div>
    <div style="background:white; border-radius:14px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
        <p style="font-size:12px; color:#94a3b8; margin-bottom:6px;">Urgent Tasks</p>
        <h3 style="font-size:28px; font-weight:700; color:#ef4444;">{{ $urgentTasks }}</h3>
    </div>
</div>

{{-- Projects Grid --}}
@if($projects->isEmpty())
    <div style="background:white; border-radius:16px; padding:60px; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
        <p style="font-size:40px; margin-bottom:15px;">📭</p>
        <p style="font-size:16px; color:#888;">Aucun projet pour le moment</p>
        <a href="{{ route('projects.create') }}" style="
            display:inline-block; margin-top:20px;
            background:#3b82f6; color:white;
            padding:10px 22px; border-radius:10px;
            text-decoration:none; font-weight:600;
        ">Créer votre premier projet</a>
    </div>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px,1fr)); gap:18px;">
        @foreach($projects as $project)
            @php
                $done  = $project->tasks->where('status','done')->count();
                $total = $project->tasks_count;
                $pct   = $total > 0 ? round(($done/$total)*100) : 0;
                $role  = $project->members->find(auth()->id())?->pivot->role ?? 'member';
                $urgent = $project->tasks->filter(fn($t) => $t->deadline_status === 'urgent')->count();

                // Status couleur
                $statusColor = match(true) {
                    $pct >= 80  => ['bg' => '#d1fae5', 'text' => '#059669', 'label' => 'Near Completion'],
                    $pct >= 30  => ['bg' => '#dbeafe', 'text' => '#2563eb', 'label' => 'In Progress'],
                    $pct === 0  => ['bg' => '#fef3c7', 'text' => '#d97706', 'label' => 'Planning'],
                    default     => ['bg' => '#ede9fe', 'text' => '#7c3aed', 'label' => 'Active'],
                };

                // Progress bar couleur
                $barColor = match(true) {
                    $pct >= 80  => '#10b981',
                    $pct >= 50  => '#3b82f6',
                    $pct >= 20  => '#f59e0b',
                    default     => '#ef4444',
                };
            @endphp

            <div style="
                background:white; border-radius:14px; padding:20px;
                box-shadow:0 2px 10px rgba(0,0,0,0.05);
                transition:box-shadow 0.2s, transform 0.2s;
                cursor:pointer;
            "
            onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'; this.style.transform='translateY(-2px)'"
            onmouseout="this.style.boxShadow='0 2px 10px rgba(0,0,0,0.05)'; this.style.transform='translateY(0)'">

                {{-- Header --}}
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;">
                    <h3 style="font-size:15px; font-weight:600; color:#1a1a2e; margin:0; flex:1; padding-right:10px;">
                        {{ $project->title }}
                    </h3>
                    <span style="
                        background:{{ $statusColor['bg'] }};
                        color:{{ $statusColor['text'] }};
                        padding:3px 10px; border-radius:20px;
                        font-size:11px; font-weight:600; white-space:nowrap;
                    ">{{ $statusColor['label'] }}</span>
                </div>

                {{-- Description --}}
                <p style="font-size:12px; color:#94a3b8; margin-bottom:14px; line-height:1.5;">
                    {{ Str::limit($project->description ?? 'No description', 65) }}
                </p>

                {{-- Progress --}}
                <div style="margin-bottom:14px;">
                    <div style="background:#f1f5f9; border-radius:10px; height:6px;">
                        <div style="background:{{ $barColor }}; border-radius:10px; height:6px; width:{{ $pct }}%;"></div>
                    </div>
                    <p style="font-size:11px; color:#94a3b8; margin-top:5px;">Progress: {{ $pct }}%</p>
                </div>

                {{-- Footer --}}
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    {{-- Avatars membres --}}
                    <div style="display:flex;">
                        {{-- ✅ Après — photo ou initiale --}}
                        @foreach($project->members->take(3) as $member)
                            @if($member->avatar)
                                <img src="{{ asset('avatars/' . $member->avatar) }}"
                                    style="
                                        width:28px; height:28px; border-radius:50%;
                                        object-fit:cover;
                                        border:2px solid white; margin-right:-6px;
                                    ">
                            @else
                                <div style="
                                    width:28px; height:28px; border-radius:50%;
                                    background:{{ $member->pivot->role === 'lead' ? '#7c3aed' : '#3b82f6' }};
                                    color:white; font-size:11px; font-weight:600;
                                    display:flex; align-items:center; justify-content:center;
                                    border:2px solid white; margin-right:-6px;
                                ">{{ strtoupper(substr($member->name,0,1)) }}</div>
                            @endif
                        @endforeach
                        @if($project->members->count() > 3)
                            <div style="
                                width:28px; height:28px; border-radius:50%;
                                background:#e2e8f0; color:#64748b;
                                font-size:10px; font-weight:600;
                                display:flex; align-items:center; justify-content:center;
                                border:2px solid white; margin-right:-6px;
                            ">+{{ $project->members->count() - 3 }}</div>
                        @endif
                    </div>

                    <span style="font-size:11px; color:#94a3b8;">
                        Due: {{ \Carbon\Carbon::parse($project->deadline)->format('M d') }}
                    </span>
                </div>

                {{-- Actions --}}
                <div style="display:flex; gap:6px; margin-top:14px; padding-top:14px; border-top:1px solid #f1f5f9;">
                    <a href="{{ route('projects.show', $project) }}" style="
                        flex:1; text-align:center;
                        background:#eff6ff; color:#3b82f6;
                        padding:7px; border-radius:8px;
                        text-decoration:none; font-size:12px; font-weight:600;
                    ">View</a>

                    @can('update', $project)
                        <a href="{{ route('projects.edit', $project) }}" style="
                            flex:1; text-align:center;
                            background:#fef3c7; color:#d97706;
                            padding:7px; border-radius:8px;
                            text-decoration:none; font-size:12px; font-weight:600;
                        ">Edit</a>
                    @endcan

                    @can('archive', $project)
                        <form action="{{ route('projects.archive', $project) }}" method="POST" style="flex:1;">
                            @csrf @method('PATCH')
                            <button style="
                                width:100%; background:#fee2e2; color:#dc2626;
                                padding:7px; border-radius:8px;
                                border:none; font-size:12px; font-weight:600;
                                cursor:pointer; font-family:'Outfit',sans-serif;
                            ">Archive</button>
                        </form>
                    @endcan
                </div>

            </div>
        @endforeach
    </div>
@endif

@endsection