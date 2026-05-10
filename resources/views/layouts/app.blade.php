<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Outfit', sans-serif; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            text-decoration: none;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 4px;
        }
        .sidebar-link:hover {
            background: #e7ecf1;
            color: #1a1a2e;
        }
        .sidebar-link.active {
            background: #eff6ff;
            color: #3b82f6;
            font-weight: 600;
        }
    </style>
</head>
<body style="background:#f4f6fb; margin:0; padding:0;">

@auth
{{-- ─── LAYOUT AVEC SIDEBAR ─────────────────────── --}}
<div style="display:flex; min-height:100vh;">

    {{-- ── SIDEBAR ──────────────────────────────── --}}
    <div style="
        width: 240px;
        background: white;
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        padding: 25px 16px;
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 100;
    ">
        {{-- Logo --}}
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:35px; padding:0 8px;">
            <div style="
                width:36px; height:36px; border-radius:10px;
                background:linear-gradient(135deg, #3b82f6, #6C63FF);
                display:flex; align-items:center; justify-content:center;
                font-size:18px;
            ">🚀</div>
            <span style="font-size:20px; font-weight:700; color:#1a1a2e;">DevTrack</span>
        </div>

        {{-- Navigation --}}
        <nav style="flex:1;">

            <p style="font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; padding:0 8px;">
                Menu
            </p>

            <a href="{{ route('projects.index') }}"
               class="sidebar-link {{ request()->routeIs('projects.index') ? 'active' : '' }}">
                <span style="font-size:18px;">📊</span>
                Dashboard
            </a>

            <a href="{{ route('projects.index') }}"
               class="sidebar-link {{ request()->routeIs('projects.show') ? 'active' : '' }}">
                <span style="font-size:18px;">📁</span>
                Projects
            </a>

            <a href="{{ route('projects.archives') }}"
               class="sidebar-link {{ request()->routeIs('projects.archives') ? 'active' : '' }}">
                <span style="font-size:18px;">🗄️</span>
                Archives
            </a>

            <div style="height:1px; background:#f1f5f9; margin:15px 0;"></div>

            <p style="font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; padding:0 8px;">
                Account
            </p>

            {{-- ✅ Lien Profile --}}
            <a href="{{ route('profile.index') }}"
               class="sidebar-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <span style="font-size:18px;">👤</span>
                Profile
            </a>

            {{-- Avatar user --}}
            <div style="padding:8px 16px; margin-top:8px;">
                <div style="display:flex; align-items:center; gap:10px;">

                    @if(auth()->user()->avatar)
                        <img src="{{ asset('avatars/' . auth()->user()->avatar) }}"
                            style="width:34px; height:34px; border-radius:50%; object-fit:cover; border:2px solid #e5e7eb;">
                    @else
                        <div style="
                            width:34px; height:34px; border-radius:50%;
                            background:linear-gradient(135deg, #3b82f6, #6C63FF);
                            color:white; display:flex; align-items:center;
                            justify-content:center; font-size:14px; font-weight:600;
                        ">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    @endif

                    <div>
                        <p style="font-size:13px; font-weight:600; color:#1a1a2e; margin:0;">
                            {{ auth()->user()->name }}
                        </p>
                        <p style="font-size:11px; color:#94a3b8; margin:0;">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                </div>
            </div>

        </nav>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" style="margin-top:15px;">
            @csrf
            <button type="submit" style="
                width:100%; padding:11px;
                background:#fee2e2; color:#dc2626;
                border:none; border-radius:10px;
                font-size:14px; font-weight:600;
                cursor:pointer; font-family:'Outfit', sans-serif;
                display:flex; align-items:center;
                justify-content:center; gap:8px;
                transition:background 0.2s;
            "
            onmouseover="this.style.background='#fecaca'"
            onmouseout="this.style.background='#fee2e2'">
                🚪 Déconnexion
            </button>
        </form>

    </div>

    {{-- ── CONTENU PRINCIPAL ────────────────────── --}}
    <div style="margin-left:240px; flex:1; padding:30px;">

        {{-- Message succès --}}
        @if(session('success'))
            <div style="
                background:#d1fae5; color:#059669;
                padding:14px 18px; border-radius:10px;
                margin-bottom:20px; font-size:14px;
                font-weight:500; display:flex;
                align-items:center; gap:8px;
            ">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Message erreur --}}
        @if(session('error'))
            <div style="
                background:#fee2e2; color:#dc2626;
                padding:14px 18px; border-radius:10px;
                margin-bottom:20px; font-size:14px;
                font-weight:500; display:flex;
                align-items:center; gap:8px;
            ">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Contenu de la page --}}
        @yield('content')

    </div>

</div>

@else
{{-- ─── LAYOUT SANS SIDEBAR (login/register) ────── --}}
@yield('content')
@endauth

</body>
</html>