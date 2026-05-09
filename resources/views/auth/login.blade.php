<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack — Connexion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div style="
    min-height: 100vh;
    background: linear-gradient(135deg, #e8eaf6 0%, #e3f2fd 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Outfit', sans-serif;
">
    <div style="
        background: white;
        border-radius: 20px;
        padding: 45px 40px;
        width: 90%;
        max-width: 420px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
    ">
        {{-- Logo --}}
        <div style="text-align:center; margin-bottom:30px;">
            <div style="display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:8px;">
                <img src="https://img.icons8.com/fluency/48/settings.png" width="36">
                <span style="font-size:24px; font-weight:700; color:#1a1a2e;">DevTrack</span>
            </div>
            <p style="color:#888; font-size:14px;">Log in to your account</p>
        </div>

        {{-- Erreurs --}}
        @if($errors->any())
            <div style="background:#fee2e2; color:#dc2626; padding:12px; border-radius:10px; margin-bottom:20px; font-size:13px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom:18px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:7px;">
                    Email address
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="name@company.com"
                       required autofocus
                       style="
                           width:100%;
                           padding:11px 15px;
                           border:1.5px solid #e5e7eb;
                           border-radius:10px;
                           font-size:14px;
                           font-family:'Outfit', sans-serif;
                           outline:none;
                           transition:border 0.2s;
                           box-sizing:border-box;
                       "
                       onfocus="this.style.borderColor='#6C63FF'"
                       onblur="this.style.borderColor='#e5e7eb'">
                @error('email')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom:18px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a2e; margin-bottom:7px;">
                    Password
                </label>
                <input type="password"
                       name="password"
                       placeholder="••••••••"
                       required
                       style="
                           width:100%;
                           padding:11px 15px;
                           border:1.5px solid #e5e7eb;
                           border-radius:10px;
                           font-size:14px;
                           font-family:'Outfit', sans-serif;
                           outline:none;
                           transition:border 0.2s;
                           box-sizing:border-box;
                       "
                       onfocus="this.style.borderColor='#6C63FF'"
                       onblur="this.style.borderColor='#e5e7eb'">
                @error('password')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:22px;">
                <label style="display:flex; align-items:center; gap:7px; font-size:13px; color:#555; cursor:pointer;">
                    <input type="checkbox" name="remember" style="accent-color:#6C63FF;">
                    Remember me
                </label>
            </div>

            {{-- Bouton Login --}}
            <button type="submit" style="
                width:100%;
                padding:13px;
                background:#3b82f6;
                color:white;
                border:none;
                border-radius:10px;
                font-size:15px;
                font-weight:600;
                font-family:'Outfit', sans-serif;
                cursor:pointer;
                transition:background 0.2s;
            "
            onmouseover="this.style.background='#2563eb'"
            onmouseout="this.style.background='#3b82f6'">
                Log In
            </button>

        </form>

        {{-- Sign Up link --}}
        <p style="text-align:center; margin-top:20px; font-size:13px; color:#888;">
            Don't have an account?
            <a href="{{ route('register') }}" style="color:#3b82f6; font-weight:600; text-decoration:none;">
                Sign Up
            </a>
        </p>

    </div>
</div>

</body>
</html>