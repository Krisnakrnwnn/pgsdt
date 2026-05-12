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

        <div style="text-align: center;">
            <p style="color: rgba(255,255,255,0.7); font-size: clamp(0.9rem, 3vw, 1.05rem); line-height: 1.6; margin-bottom: 30px; font-family: 'Inter', sans-serif;">
                Untuk keamanan dan kemudahan krama, akses portal sekarang menggunakan akun <strong style="color: white;">Gmail / Google</strong>.
            </p>

            <a href="{{ route('auth.google') }}" style="width: 100%; padding: 18px 10px; border-radius: 16px; border: 2px solid var(--accent-gold); background: rgba(212,175,55,0.1); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: clamp(0.85rem, 4vw, 1.05rem); font-weight: 700; font-family: 'Cinzel', serif; transition: all 0.3s; box-sizing: border-box; text-transform: uppercase; letter-spacing: 1px; white-space: nowrap;" 
               onmouseover="this.style.background='var(--accent-gold)'; this.style.color='var(--primary-dark)'" 
               onmouseout="this.style.background='rgba(212,175,55,0.1)'; this.style.color='white'">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" style="width: 20px; height: 20px; margin-right: 10px;">
                Masuk dengan Google
            </a>

            <div style="margin-top: 35px; padding: 15px; background: rgba(212,175,55,0.05); border-radius: 12px; border: 1px dashed rgba(212,175,55,0.3);">
                <p style="color: var(--accent-gold-light); font-size: 0.75rem; margin: 0; line-height: 1.5;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline; margin-bottom: -2px; margin-right: 4px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pendaftaran anggota baru juga dilakukan melalui tombol di atas.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
