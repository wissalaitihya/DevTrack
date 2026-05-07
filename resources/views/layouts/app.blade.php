<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <a href="{{ route('projects.index') }}" class="navbar-brand">
            🚀 DevTrack
        </a>
//
        <ul class="navbar-nav">
            @auth
                <li><a href="{{ route('projects.index') }}">Dashboard</a></li>
                <li><a href="{{ route('projects.archived') }}">Archives</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">
                            Déconnexion
                        </button>
                    </form>
                </li>
            @endauth

            @guest
                <li><a href="{{ route('login') }}">Connexion</a></li>
                <li><a href="{{ route('register') }}">Inscription</a></li>
            @endguest
        </ul>
    </nav>

    {{-- CONTENU --}}
    <div class="container">

        {{-- Messages succès --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Messages erreur --}}
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        {{-- Contenu de la page --}}
        @yield('content')

    </div>

</body>
</html>