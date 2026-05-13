@extends('layouts.app')

@section('title', 'Login - Dalem Tarukan')

@section('content')
<div style="min-height: 100vh; background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; padding: 20px; position: relative;">
    <!-- Overlay Gradient -->
    <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(10,31,28,0.85), rgba(10,31,28,0.95)); z-index: 0;"></div>
    
    <div style="position: relative; z-index: 10; width: 100%; max-width: 450px; background: rgba(255,255,255,0.05); backdrop-filter: blur(24px); border: 1px solid rgba(212,175,55,0.2); border-radius: 24px; padding: clamp(30px, 8vw, 50px); box-shadow: 0 25px 50px rgba(0,0,0,0.5);" data-aos="zoom-in">
        
        <!-- LOGO & TITLE -->
        <div style="text-align: center; margin-bottom: 35px;">
            <img src="{{ asset('assets/Logo.png') }}" alt="Dalem Tarukan" style="height: 65px; margin: 0 auto 20px; display: block;">
            <h1 style="font-family: 'Cinzel', serif; color: var(--accent-gold); font-size: clamp(1.5rem, 5vw, 1.8rem); margin: 0; letter-spacing: 2px;">PORTAL MASUK</h1>
            <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin-top: 8px; font-family: 'Cinzel', serif;">Masuk ke sistem informasi krama PGSDT</p>
        </div>

        @if ($errors->any())
            <div style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); color: #ff8d97; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 0.85rem;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Admin Login Form --}}
        <form method="POST" action="{{ route('login') }}" style="margin-bottom: 0;">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="admin_email" style="display: block; color: rgba(255,255,255,0.6); font-size: 0.78rem; margin-bottom: 8px; font-family: 'Inter', sans-serif;">Email</label>
                <input
                    type="email"
                    id="admin_email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    placeholder="Email admin"
                    style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.06); border: 1px solid rgba(212,175,55,0.25); border-radius: 12px; color: white; font-size: 0.9rem; font-family: 'Inter', sans-serif; outline: none; box-sizing: border-box; transition: border-color 0.3s;"
                    onfocus="this.style.borderColor='rgba(212,175,55,0.6)'"
                    onblur="this.style.borderColor='rgba(212,175,55,0.25)'"
                >
            </div>

            <div style="margin-bottom: 22px;">
                <label for="admin_password" style="display: block; color: rgba(255,255,255,0.6); font-size: 0.78rem; margin-bottom: 8px; font-family: 'Inter', sans-serif;">Password</label>
                <div style="position: relative;">
                    <input
                        type="password"
                        id="admin_password"
                        name="password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        style="width: 100%; padding: 14px 46px 14px 16px; background: rgba(255,255,255,0.06); border: 1px solid rgba(212,175,55,0.25); border-radius: 12px; color: white; font-size: 0.9rem; font-family: 'Inter', sans-serif; outline: none; box-sizing: border-box; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='rgba(212,175,55,0.6)'"
                        onblur="this.style.borderColor='rgba(212,175,55,0.25)'"
                    >
                    <button type="button" onclick="togglePassword()" style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: rgba(255,255,255,0.4); padding: 0;">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit"
                style="width: 100%; padding: 15px; border-radius: 12px; border: 1px solid rgba(212,175,55,0.5); background: rgba(212,175,55,0.15); color: var(--accent-gold); font-size: 0.9rem; font-weight: 700; font-family: 'Cinzel', serif; cursor: pointer; letter-spacing: 1px; transition: all 0.3s; text-transform: uppercase; margin-bottom: 0;"
                onmouseover="this.style.background='rgba(212,175,55,0.9)'; this.style.color='#0a1f1c';"
                onmouseout="this.style.background='rgba(212,175,55,0.15)'; this.style.color='var(--accent-gold)';"
            >
                Masuk
            </button>
        </form>

        {{-- Divider --}}
        <div style="display: flex; align-items: center; margin: 28px 0;">
            <div style="flex: 1; height: 1px; background: rgba(255,255,255,0.1);"></div>
            <span style="padding: 0 14px; color: rgba(255,255,255,0.35); font-size: 0.78rem; font-family: 'Inter', sans-serif;">atau masuk sebagai krama</span>
            <div style="flex: 1; height: 1px; background: rgba(255,255,255,0.1);"></div>
        </div>

        {{-- Google Login --}}
        <a href="{{ route('auth.google') }}" style="width: 100%; padding: 18px 10px; border-radius: 16px; border: 2px solid var(--accent-gold); background: rgba(212,175,55,0.1); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: clamp(0.85rem, 4vw, 1.05rem); font-weight: 700; font-family: 'Cinzel', serif; transition: all 0.3s; box-sizing: border-box; text-transform: uppercase; letter-spacing: 1px; white-space: nowrap;"
           onmouseover="this.style.background='var(--accent-gold)'; this.style.color='var(--primary-dark)'"
           onmouseout="this.style.background='rgba(212,175,55,0.1)'; this.style.color='white'">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" style="width: 20px; height: 20px; margin-right: 10px;">
            Masuk dengan Google
        </a>

        <div style="margin-top: 20px; padding: 15px; background: rgba(212,175,55,0.05); border-radius: 12px; border: 1px dashed rgba(212,175,55,0.3);">
            <p style="color: var(--accent-gold-light); font-size: 0.75rem; margin: 0; line-height: 1.5;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; margin-bottom: -2px; margin-right: 4px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pendaftaran anggota baru juga dilakukan melalui tombol di atas.
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('admin_password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection
