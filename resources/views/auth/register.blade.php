<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevTrack — Inscription</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div style="
    min-height: 100vh;
    background: #e8eef7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Outfit', sans-serif;
">

    {{-- Header --}}
    <div style="position:fixed; top:0; left:0; right:0; padding:18px 40px; display:flex; justify-content:space-between; align-items:center;">
        <div style="display:flex; align-items:center; gap:8px;">
            <img src="https://img.icons8.com/fluency/48/settings.png" width="28">
            <span style="font-size:18px; font-weight:700; color:#1a1a2e;">DevTrack</span>
        </div>
        <p style="font-size:13px; color:#555;">
            Already have an account?
            <a href="{{ route('login') }}" style="color:#3b82f6; font-weight:600; text-decoration:none;">Log In</a>
        </p>
    </div>

    {{-- Card --}}
    <div style="
        background: white;
        border-radius: 20px;
        padding: 45px 40px;
        width: 90%;
        max-width: 460px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-top: 60px;
    ">

        <h2 style="font-size:26px; font-weight:700; color:#1a1a2e; text-align:center; margin-bottom:30px;">
            Join DevTrack
        </h2>

        {{-- Erreurs --}}
        @if($errors->any())
            <div style="background:#fee2e2; color:#dc2626; padding:12px; border-radius:10px; margin-bottom:20px; font-size:13px;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Full Name --}}
            <div style="margin-bottom:16px;">
                <div style="position:relative;">
                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#aaa;">👤</span>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Full Name"
                           required autofocus
                           style="
                               width:100%;
                               padding:12px 15px 12px 40px;
                               border:1.5px solid #e5e7eb;
                               border-radius:25px;
                               font-size:14px;
                               font-family:'Outfit', sans-serif;
                               outline:none;
                               box-sizing:border-box;
                           "
                           onfocus="this.style.borderColor='#3b82f6'"
                           onblur="this.style.borderColor='#e5e7eb'">
                </div>
                @error('name')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px; padding-left:15px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom:16px;">
                <div style="position:relative;">
                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#aaa;">✉️</span>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Email Address"
                           required
                           style="
                               width:100%;
                               padding:12px 15px 12px 40px;
                               border:1.5px solid #e5e7eb;
                               border-radius:25px;
                               font-size:14px;
                               font-family:'Outfit', sans-serif;
                               outline:none;
                               box-sizing:border-box;
                           "
                           onfocus="this.style.borderColor='#3b82f6'"
                           onblur="this.style.borderColor='#e5e7eb'">
                </div>
                @error('email')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px; padding-left:15px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom:16px;">
                <div style="position:relative;">
                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#aaa;">🔒</span>
                    <input type="password"
                           name="password"
                           placeholder="Password"
                           required
                           style="
                               width:100%;
                               padding:12px 15px 12px 40px;
                               border:1.5px solid #e5e7eb;
                               border-radius:25px;
                               font-size:14px;
                               font-family:'Outfit', sans-serif;
                               outline:none;
                               box-sizing:border-box;
                           "
                           onfocus="this.style.borderColor='#3b82f6'"
                           onblur="this.style.borderColor='#e5e7eb'">
                </div>
                @error('password')
                    <p style="color:#dc2626; font-size:12px; margin-top:4px; padding-left:15px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div style="margin-bottom:25px;">
                <div style="position:relative;">
                    <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#aaa;">🔒</span>
                    <input type="password"
                           name="password_confirmation"
                           placeholder="Confirm Password"
                           required
                           style="
                               width:100%;
                               padding:12px 15px 12px 40px;
                               border:1.5px solid #e5e7eb;
                               border-radius:25px;
                               font-size:14px;
                               font-family:'Outfit', sans-serif;
                               outline:none;
                               box-sizing:border-box;
                           "
                           onfocus="this.style.borderColor='#3b82f6'"
                           onblur="this.style.borderColor='#e5e7eb'">
                </div>
            </div>

            {{-- Bouton Sign Up --}}
            <button type="submit" style="
                width:100%;
                padding:13px;
                background:#3b82f6;
                color:white;
                border:none;
                border-radius:25px;
                font-size:15px;
                font-weight:600;
                font-family:'Outfit', sans-serif;
                cursor:pointer;
                transition:background 0.2s;
            "
            onmouseover="this.style.background='#2563eb'"
            onmouseout="this.style.background='#3b82f6'">
                Sign Up
            </button>

        </form>

        {{-- Footer links --}}
        <p style="text-align:center; margin-top:25px; font-size:12px; color:#aaa;">
            <a href="#" style="color:#aaa; text-decoration:none;">Privacy Policy</a> &nbsp;·&nbsp;
            <a href="#" style="color:#aaa; text-decoration:none;">Terms of Service</a> &nbsp;·&nbsp;
            <a href="#" style="color:#aaa; text-decoration:none;">Contact Us</a>
        </p>

    </div>
</div>

</body>
</html>