<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="welcome-page">
    <div class="welcome-box">
        <h1>🚀 DevTrack</h1>
        <p>Gérez vos projets et tâches simplement</p>

        <div class="welcome-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">
                Connexion
            </a>
            <a href="{{ route('register') }}" class="btn btn-secondary">
                Inscription
            </a>
        </div>
    </div>
</div>

</body>
</html>