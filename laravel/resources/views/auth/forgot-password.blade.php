@extends('layouts.app')

@section('title', 'Lupa Kata Sandi - Dalem Tarukan')

@section('content')
<div style="min-height: 100vh; background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; padding: 20px; position: relative;">
    <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(10,31,28,0.85), rgba(10,31,28,0.95)); z-index: 0;"></div>

    <div style="position: relative; z-index: 10; width: 100%; max-width: 480px; background: rgba(255,255,255,0.05); backdrop-filter: blur(24px); border: 1px solid rgba(212,175,55,0.2); border-radius: 24px; padding: 50px; box-shadow: 0 25px 50px rgba(0,0,0,0.5);" data-aos="zoom-in">

        <div style="text-align: center; margin-bottom: 35px;">
            <img src="{{ asset('assets/Logo.png') }}" alt="Dalem Tarukan" style="height: 60px; margin-bottom: 20px;">
            <h1 style="font-family: 'Cinzel', serif; color: var(--accent-gold); font-size: 1.6rem; margin: 0; letter-spacing: 2px;">LUPA KATA SANDI</h1>
            <p style="color: rgba(255,255,255,0.55); font-size: 0.88rem; margin-top: 12px; line-height: 1.6;">
                Masukkan email terdaftar Anda. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
            </p>
        </div>

        @if(session('status'))
        <div style="background: rgba(39,174,96,0.15); border: 1px solid rgba(39,174,96,0.4); color: #2ecc71; padding: 15px 18px; border-radius: 12px; margin-bottom: 25px; font-size: 0.88rem; line-height: 1.5; display: flex; gap: 10px; align-items: flex-start;">
            <span style="flex-shrink: 0; font-size: 1.1rem;">✅</span>
            <span>{{ session('status') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); color: #ff8d97; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 0.85rem;">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div style="margin-bottom: 28px;">
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Email Terdaftar</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: rgba(212,175,55,0.7);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           style="width: 100%; padding: 14px 16px 14px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-family: 'Inter', sans-serif; font-size: 0.95rem; outline: none; box-sizing: border-box; transition: border-color 0.3s;"
                           placeholder="nama@email.com" required autofocus
                           onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 16px; border-radius: 12px; border: none; cursor: pointer; font-size: 1rem; letter-spacing: 2px;">
                KIRIM TAUTAN RESET
            </button>
        </form>

        <div style="text-align: center; margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 24px;">
            <a href="{{ route('login') }}" style="color: rgba(255,255,255,0.5); font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: color 0.3s;"
               onmouseover="this.style.color='var(--accent-gold)'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke halaman masuk
            </a>
        </div>
    </div>
</div>
@endsection
