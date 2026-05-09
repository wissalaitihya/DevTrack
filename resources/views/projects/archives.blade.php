@extends('layouts.app')

@section('content')

{{-- ─── HEADER ──────────────────────────────────── --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <div>
        <h1 style="font-size:24px; font-weight:700; color:#1a1a2e;">
            🗄️ Archives
        </h1>
        <p style="color:#888; font-size:13px; margin-top:4px;">
            Projets archivés — restaurez ou supprimez définitivement
        </p>
    </div>
    <a href="{{ route('projects.index') }}" style="
        background:#f1f5f9; color:#64748b;
        padding:10px 20px; border-radius:10px;
        text-decoration:none; font-weight:600; font-size:14px;
    ">← Dashboard</a>
</div>

{{-- ─── STATS ───────────────────────────────────── --}}
<div style="
    background:white; border-radius:14px;
    padding:20px 25px; margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
    display:flex; align-items:center; gap:15px;
">
    <div style="
        width:45px; height:45px; border-radius:12px;
        background:#fee2e2; display:flex;
        align-items:center; justify-content:center;
        font-size:20px;
    ">🗑️</div>
    <div>
        <p style="font-size:13px; color:#888; margin-bottom:2px;">Projets archivés</p>
        <h3 style="font-size:22px; font-weight:700; color:#1a1a2e;">{{ $projects->count() }}</h3>
    </div>
</div>

{{-- ─── LISTE PROJETS ARCHIVÉS ──────────────────── --}}
@if($projects->isEmpty())
    <div style="
        background:white; border-radius:14px; padding:60px;
        text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.05);
    ">
        <p style="font-size:40px; margin-bottom:15px;">📭</p>
        <p style="font-size:16px; color:#888; margin-bottom:5px;">Aucun projet archivé</p>
        <p style="font-size:13px; color:#aaa;">Les projets archivés apparaîtront ici</p>
        <a href="{{ route('projects.index') }}" style="
            display:inline-block; margin-top:20px;
            background:#3b82f6; color:white;
            padding:10px 22px; border-radius:10px;
            text-decoration:none; font-weight:600; font-size:14px;
        ">Retour au Dashboard</a>
    </div>

@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:18px;">
        @foreach($projects as $project)
            @php
                $tasksCount = $project->tasks->count();
                $doneCount  = $project->tasks->where('status', 'done')->count();
                $pct        = $tasksCount > 0 ? round(($doneCount / $tasksCount) * 100) : 0;
            @endphp

            <div style="
                background:white; border-radius:14px; padding:20px;
                box-shadow:0 2px 10px rgba(0,0,0,0.05);
                border-left:4px solid #94a3b8;
                opacity:0.85;
            ">
                {{-- Header --}}
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;">
                    <h3 style="font-size:16px; font-weight:600; color:#1a1a2e;">
                        {{ $project->title }}
                    </h3>
                    <span style="
                        background:#f1f5f9; color:#64748b;
                        padding:3px 10px; border-radius:20px;
                        font-size:11px; font-weight:600;
                    ">Archivé</span>
                </div>

                {{-- Description --}}
                <p style="font-size:13px; color:#888; margin-bottom:12px; line-height:1.5;">
                    {{ Str::limit($project->description ?? 'Aucune description', 70) }}
                </p>

                {{-- Meta --}}
                <div style="font-size:12px; color:#94a3b8; margin-bottom:12px;">
                    <p>📅 Deadline : {{ \Carbon\Carbon::parse($project->deadline)->format('d M Y') }}</p>
                    <p style="margin-top:4px;">
                        🗑️ Archivé le : {{ \Carbon\Carbon::parse($project->deleted_at)->format('d M Y') }}
                    </p>
                </div>

                {{-- Progress --}}
                <div style="margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; font-size:12px; color:#888; margin-bottom:5px;">
                        <span>Progress: {{ $pct }}%</span>
                        <span>{{ $doneCount }}/{{ $tasksCount }} tasks</span>
                    </div>
                    <div style="background:#f0f0f0; border-radius:10px; height:6px;">
                        <div style="background:#94a3b8; border-radius:10px; height:6px; width:{{ $pct }}%;"></div>
                    </div>
                </div>

                {{-- Membres --}}
                <div style="display:flex; gap:5px; margin-bottom:16px;">
                    @foreach($project->members->take(4) as $member)
                        <div style="
                            width:28px; height:28px; border-radius:50%;
                            background:#3b82f6; color:white;
                            display:flex; align-items:center; justify-content:center;
                            font-size:11px; font-weight:600;
                            border:2px solid white;
                        ">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                    @endforeach
                    @if($project->members->count() > 4)
                        <div style="
                            width:28px; height:28px; border-radius:50%;
                            background:#e2e8f0; color:#64748b;
                            display:flex; align-items:center; justify-content:center;
                            font-size:10px; font-weight:600;
                            border:2px solid white;
                        ">+{{ $project->members->count() - 4 }}</div>
                    @endif
                </div>

                {{-- Actions --}}
                <div style="display:flex; gap:8px;">

                    {{-- Restaurer --}}
                    @can('restore', $project)
                        <form action="{{ route('projects.restore', $project->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button style="
                                background:#d1fae5; color:#059669;
                                padding:8px 16px; border-radius:8px;
                                border:none; font-size:13px; font-weight:600;
                                cursor:pointer; font-family:'Outfit', sans-serif;
                            "
                            onmouseover="this.style.background='#a7f3d0'"
                            onmouseout="this.style.background='#d1fae5'">
                                ♻️ Restaurer
                            </button>
                        </form>
                    @endcan

                    {{-- Supprimer définitivement --}}
                    @can('forceDelete', $project)
                        <form action="{{ route('projects.forceDelete', $project->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button
                                onclick="return confirm('⚠️ Supprimer définitivement ? Cette action est irréversible !')"
                                style="
                                    background:#fee2e2; color:#dc2626;
                                    padding:8px 16px; border-radius:8px;
                                    border:none; font-size:13px; font-weight:600;
                                    cursor:pointer; font-family:'Outfit', sans-serif;
                                "
                                onmouseover="this.style.background='#fecaca'"
                                onmouseout="this.style.background='#fee2e2'">
                                🗑️ Supprimer
                            </button>
                        </form>
                    @endcan

                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection