@extends('layouts.app')

@section('content')

<div style="display:grid; grid-template-columns:320px 1fr; gap:25px;">

    {{-- ── LEFT COLUMN ──────────────────────────── --}}
    <div>

        {{-- Avatar Card --}}
        <div style="
            background:white; border-radius:16px;
            padding:30px; text-align:center;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
            margin-bottom:20px;
        ">
            {{-- Avatar --}}
            <div style="position:relative; display:inline-block; margin-bottom:15px;">

                @if($user->avatar)
                    <img src="{{ asset('avatars/' . $user->avatar) }}"
                        style="
                            width:90px; height:90px; border-radius:50%;
                            object-fit:cover; border:3px solid #e5e7eb;
                        ">
                @else
                    <div style="
                        width:90px; height:90px; border-radius:50%;
                        background:linear-gradient(135deg, #3b82f6, #6C63FF);
                        color:white; font-size:36px; font-weight:700;
                        display:flex; align-items:center; justify-content:center;
                        margin:0 auto;
                    ">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                {{-- Bouton changer photo --}}
                <label for="avatar-input" style="
                    position:absolute; bottom:0; right:0;
                    width:28px; height:28px; border-radius:50%;
                    background:#3b82f6; color:white;
                    display:flex; align-items:center; justify-content:center;
                    font-size:13px; border:2px solid white;
                    cursor:pointer;
                ">✏️</label>

            </div>

            <h2 style="font-size:20px; font-weight:700; color:#1a1a2e; margin-bottom:4px;">
                {{ $user->name }}
            </h2>
            <p style="font-size:13px; color:#94a3b8;">{{ $globalRole }}</p>
        </div>

        {{-- Stats Cards --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">

            <div style="background:white; border-radius:14px; padding:16px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size:24px; font-weight:700; color:#3b82f6; margin-bottom:4px;">
                    {{ $totalProjects }}
                </h3>
                <p style="font-size:11px; color:#94a3b8; margin:0;">Projects</p>
            </div>

            <div style="background:white; border-radius:14px; padding:16px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size:24px; font-weight:700; color:#059669; margin-bottom:4px;">
                    {{ $completedTasks }}
                </h3>
                <p style="font-size:11px; color:#94a3b8; margin:0;">Done</p>
            </div>

            <div style="background:white; border-radius:14px; padding:16px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size:24px; font-weight:700; color:#d97706; margin-bottom:4px;">
                    {{ $inProgressTasks }}
                </h3>
                <p style="font-size:11px; color:#94a3b8; margin:0;">In Progress</p>
            </div>

            <div style="background:white; border-radius:14px; padding:16px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <h3 style="font-size:24px; font-weight:700; color:#1a1a2e; margin-bottom:4px;">
                    {{ $totalTasks }}
                </h3>
                <p style="font-size:11px; color:#94a3b8; margin:0;">Total Tasks</p>
            </div>

        </div>

        {{-- Personal Information --}}
        <div style="background:white; border-radius:16px; padding:25px; box-shadow:0 2px 10px rgba(0,0,0,0.05); margin-bottom:20px;">

            <h3 style="font-size:15px; font-weight:600; color:#1a1a2e; margin-bottom:20px;">
                Personal Information
            </h3>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PATCH')

                        {{-- ✅ Input image caché --}}
                        <input type="file" id="avatar-input" name="avatar"
                            accept="image/*" style="display:none;"
                            onchange="previewAvatar(this)">

                        {{-- Full Name --}}
                        <div style="margin-bottom:15px;">
                            <label style="font-size:12px; color:#94a3b8; font-weight:500; display:block; margin-bottom:6px;">
                                Full Name
                            </label>
                            <input type="text" name="name"
                                value="{{ $user->name }}"
                                style="
                                    width:100%; padding:10px 14px;
                                    border:1.5px solid #e5e7eb; border-radius:10px;
                                    font-size:14px; outline:none;
                                    font-family:'Outfit', sans-serif;
                                    box-sizing:border-box;
                                "
                                onfocus="this.style.borderColor='#3b82f6'"
                                onblur="this.style.borderColor='#e5e7eb'">
                            @error('name')
                                <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div style="margin-bottom:15px;">
                            <label style="font-size:12px; color:#94a3b8; font-weight:500; display:block; margin-bottom:6px;">
                                Email Address
                            </label>
                            <input type="email" value="{{ $user->email }}" disabled
                                style="
                                    width:100%; padding:10px 14px;
                                    border:1.5px solid #e5e7eb; border-radius:10px;
                                    font-size:14px; background:#f8fafc; color:#94a3b8;
                                    font-family:'Outfit', sans-serif; box-sizing:border-box;
                                ">
                        </div>

                        {{-- Member Since --}}
                        <div style="margin-bottom:20px;">
                            <label style="font-size:12px; color:#94a3b8; font-weight:500; display:block; margin-bottom:6px;">
                                Member Since
                            </label>
                            <input type="text" value="{{ $user->created_at->format('d M Y') }}" disabled
                                style="
                                    width:100%; padding:10px 14px;
                                    border:1.5px solid #e5e7eb; border-radius:10px;
                                    font-size:14px; background:#f8fafc; color:#94a3b8;
                                    font-family:'Outfit', sans-serif; box-sizing:border-box;
                                ">
                        </div>

                        <button type="submit" style="
                            width:100%; padding:12px;
                            background:#1e3a5f; color:white;
                            border:none; border-radius:10px;
                            font-size:14px; font-weight:600;
                            cursor:pointer; font-family:'Outfit', sans-serif;
                            margin-bottom:10px;
                            "
                            onmouseover="this.style.background='#2563eb'"
                            onmouseout="this.style.background='#1e3a5f'">
                                Update Profile
                        </button>

                 </form>

            {{-- Logout --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="
                    width:100%; padding:12px;
                    background:white; color:#64748b;
                    border:1.5px solid #e5e7eb; border-radius:10px;
                    font-size:14px; font-weight:600;
                    cursor:pointer; font-family:'Outfit', sans-serif;
                ">
                    Logout
                </button>
            </form>

        </div>

    </div>

    {{-- ── RIGHT COLUMN ─────────────────────────── --}}
    <div>

        {{-- My Tasks --}}
        <div style="
            background:white; border-radius:16px; padding:25px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
            margin-bottom:20px;
        ">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3 style="font-size:15px; font-weight:600; color:#1a1a2e; margin:0;">My Tasks</h3>
                <span style="
                    background:#eff6ff; color:#3b82f6;
                    padding:4px 12px; border-radius:20px;
                    font-size:12px; font-weight:600;
                ">Recent tasks</span>
            </div>

            @if($myTasks->isEmpty())
                <div style="text-align:center; padding:40px 0; color:#94a3b8;">
                    <p style="font-size:30px; margin-bottom:10px;">📭</p>
                    <p style="font-size:14px;">Aucune tâche assignée</p>
                </div>
            @else
                @foreach($myTasks as $task)
                    <div style="
                        padding:16px 0;
                        border-bottom:1px solid #f1f5f9;
                    ">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">

                            <div style="flex:1;">
                                <h4 style="font-size:14px; font-weight:600; color:#1a1a2e; margin:0 0 4px;">
                                    {{ $task->title }}
                                </h4>
                                <div style="display:flex; align-items:center; gap:10px; font-size:12px; color:#94a3b8;">
                                    @if($task->deadline)
                                        <span>📅 Due {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</span>
                                    @endif
                                    @if($task->deadline_status === 'urgent')
                                        <span style="color:#ef4444; font-weight:600;">🔴 Urgent</span>
                                    @endif
                                </div>
                            </div>

                            <div style="display:flex; flex-direction:column; align-items:flex-end; gap:5px; margin-left:10px;">
                                {{-- Status badge --}}
                                <span style="
                                    padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;
                                    background:{{ $task->status === 'done' ? '#d1fae5' : ($task->status === 'in_progress' ? '#fef3c7' : '#f1f5f9') }};
                                    color:{{ $task->status === 'done' ? '#059669' : ($task->status === 'in_progress' ? '#d97706' : '#64748b') }};
                                    white-space:nowrap;
                                ">
                                    {{ $task->status_label }}
                                </span>

                                {{-- Project tag --}}
                                @if($task->project)
                                    <span style="
                                        background:#f1f5f9; color:#64748b;
                                        padding:2px 10px; border-radius:20px;
                                        font-size:11px; font-weight:500;
                                    ">
                                        {{ Str::limit($task->project->title, 15) }}
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        {{-- My Projects --}}
        <div style="
            background:white; border-radius:16px; padding:25px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        ">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3 style="font-size:15px; font-weight:600; color:#1a1a2e; margin:0;">My Projects</h3>
                <a href="{{ route('projects.index') }}" style="
                    font-size:12px; color:#3b82f6;
                    text-decoration:none; font-weight:600;
                ">View all →</a>
            </div>

            @php
                $userProjects = auth()->user()->projects()->with(['tasks','members'])->withCount('tasks')->get();
            @endphp

            @if($userProjects->isEmpty())
                <p style="color:#94a3b8; font-size:13px; text-align:center; padding:20px 0;">
                    Aucun projet
                </p>
            @else
                @foreach($userProjects->take(4) as $project)
                    @php
                        $done  = $project->tasks->where('status','done')->count();
                        $total = $project->tasks_count;
                        $pct   = $total > 0 ? round(($done/$total)*100) : 0;
                        $role  = $project->members->find(auth()->id())?->pivot->role ?? 'member';
                    @endphp

                    <div style="margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid #f1f5f9;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <a href="{{ route('projects.show', $project) }}" style="
                                font-weight:600; font-size:14px;
                                color:#1a1a2e; text-decoration:none;
                            ">{{ $project->title }}</a>
                            <span style="
                                background:{{ $role === 'lead' ? '#ede9fe' : '#dbeafe' }};
                                color:{{ $role === 'lead' ? '#7c3aed' : '#2563eb' }};
                                padding:2px 10px; border-radius:20px;
                                font-size:11px; font-weight:600;
                            ">{{ ucfirst($role) }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:12px; color:#94a3b8; margin-bottom:6px;">
                            <span>Progress: {{ $pct }}%</span>
                            <span>📅 {{ \Carbon\Carbon::parse($project->deadline)->format('M d') }}</span>
                        </div>
                        <div style="background:#f0f0f0; border-radius:10px; height:5px;">
                            <div style="background:#3b82f6; border-radius:10px; height:5px; width:{{ $pct }}%;"></div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

    </div>

</div>

    <script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Remplacer l'avatar affiché
                const avatar = document.querySelector('.avatar-display');
                if (avatar) {
                    avatar.src = e.target.result;
                }
            };
            reader.readAsDataURL(input.files[0]);
            // Soumettre le formulaire automatiquement
            input.closest('form').submit();
        }
    }
    </script>

@endsection