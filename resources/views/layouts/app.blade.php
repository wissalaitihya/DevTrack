<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen',
                'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica
 Neue', sans-serif;
 background-color: #f5f7fa;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 155px;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8c 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .sidebar-header {
            padding: 0 15px 30px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }

        .sidebar-brand svg {
            width: 24px;
            height: 24px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 10px;
            margin-bottom: 40px;
        }

        .sidebar-nav li {
            margin-bottom: 10px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .sidebar-nav svg {
            width: 20px;
            height: 20px;
        }

        .sidebar-bottom {
            position: absolute;
            bottom: 20px;
            width: 100%;
            padding: 0 10px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-user:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .sidebar-user-info {
            flex: 1;
        }

        .sidebar-user-name {
            font-size: 12px;
            font-weight: 600;
            color: white;
        }

        .sidebar-user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 155px;
            flex: 1;
            overflow-y: auto;
        }

        .topbar {
            background-color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .topbar-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .topbar-date {
            font-size: 14px;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-content {
            padding: 30px;
        }

        /* ALERTS */
        .alerts-container {
            margin-bottom: 20px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }

            .main-content {
                margin-left: 60px;
            }

            .sidebar-nav a span {
                display: none;
            }

            .topbar {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    @auth
        <div class="app-layout">
            {{-- SIDEBAR --}}
            <aside class="sidebar">
                <div class="sidebar-header">
                    <a href="{{ route('projects.index') }}" class="sidebar-brand">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
                        </svg>
                        <span>DevTrack</span>
                    </a>
                </div>

                <nav class="sidebar-nav">
                    <li>
                        <a href="{{ route('projects.index') }}"
                            class="{{ request()->routeIs('projects.index') ? 'active' : '' }}">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                            <span>Members</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Profile</span>
                        </a>
                    </li>
                </nav>

                <div class="sidebar-bottom">
                    <div class="sidebar-user">
                        <div class="sidebar-avatar">
                            {{ auth()->user()->name[0] ?? 'U' }}
                        </div>
                        <div class="sidebar-user-info">
                            <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                            <div class="sidebar-user-role">User</div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        <button type="submit" class="sidebar-nav"
                            style="width: 100%; border: none; background: none; cursor: pointer; padding: 12px 15px; color: rgba(255, 255, 255, 0.8); font-size: 14px;">
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            {{-- MAIN CONTENT --}}
            <div class="main-content">
                <div class="topbar">
                    <h1 class="topbar-title">Main Dashboard</h1>
                    <div class="topbar-date">
                        📅 Date {{ now()->format('M d, Y') }}
                    </div>
                </div>

                <div class="page-content">
                    {{-- Messages --}}
                    <div class="alerts-container">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-error">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>

                    {{-- Page Content --}}
                    @yield('content')
                </div>
            </div>
        </div>
    @endauth

    @guest
        {{-- GUEST LAYOUT --}}
        @yield('content')
    @endguest
</body>

</html>