@extends('layouts.app')

@section('title', 'Atur Ulang Kata Sandi - Dalem Tarukan')

@section('content')
<div style="min-height: 100vh; background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; padding: 20px; position: relative;">
    <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(10,31,28,0.85), rgba(10,31,28,0.95)); z-index: 0;"></div>

    <div style="position: relative; z-index: 10; width: 100%; max-width: 480px; background: rgba(255,255,255,0.05); backdrop-filter: blur(24px); border: 1px solid rgba(212,175,55,0.2); border-radius: 24px; padding: 50px; box-shadow: 0 25px 50px rgba(0,0,0,0.5);" data-aos="zoom-in">

        <div style="text-align: center; margin-bottom: 35px;">
            <img src="{{ asset('assets/Logo.png') }}" alt="Dalem Tarukan" style="height: 60px; margin-bottom: 20px;">
            <h1 style="font-family: 'Cinzel', serif; color: var(--accent-gold); font-size: 1.6rem; margin: 0; letter-spacing: 2px;">ATUR ULANG SANDI</h1>
            <p style="color: rgba(255,255,255,0.55); font-size: 0.88rem; margin-top: 12px;">
                Masukkan kata sandi baru untuk akun Anda.
            </p>
        </div>

        @if($errors->any())
        <div style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); color: #ff8d97; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 0.85rem;">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div style="margin-bottom: 24px;">
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Email</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: rgba(212,175,55,0.7);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input type="email" name="email" value="{{ old('email', request('email')) }}"
                           style="width: 100%; padding: 14px 16px 14px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-family: 'Inter', sans-serif; font-size: 0.95rem; outline: none; box-sizing: border-box; transition: border-color 0.3s;"
                           placeholder="nama@email.com" required
                           onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Kata Sandi Baru</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: rgba(212,175,55,0.7);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input type="password" name="password" id="password"
                           style="width: 100%; padding: 14px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-family: 'Inter', sans-serif; font-size: 0.95rem; outline: none; box-sizing: border-box; transition: border-color 0.3s;"
                           placeholder="Minimal 8 karakter" required minlength="8"
                           onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    <button type="button" onclick="togglePass('password','eye1')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: rgba(255,255,255,0.4); cursor: pointer;">
                        <svg id="eye1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 32px;">
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Konfirmasi Kata Sandi</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: rgba(212,175,55,0.7);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           style="width: 100%; padding: 14px 48px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; color: white; font-family: 'Inter', sans-serif; font-size: 0.95rem; outline: none; box-sizing: border-box; transition: border-color 0.3s;"
                           placeholder="Ulangi kata sandi baru" required
                           onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    <button type="button" onclick="togglePass('password_confirmation','eye2')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: rgba(255,255,255,0.4); cursor: pointer;">
                        <svg id="eye2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 16px; border-radius: 12px; border: none; cursor: pointer; font-size: 1rem; letter-spacing: 2px;">
                SIMPAN KATA SANDI BARU
            </button>
        </form>
    </div>
</div>

<script>
function togglePass(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.057 10.057 0 012.183-4.403M15 12a3 3 0 11-6 0 3 3 0 016 0zm6.357 7.948l-1.815-1.815m-1.414-1.414L5.122 5.122m1.414 1.414l3.536 3.536m4.243 4.243l3.536 3.536" />';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
    }
}
</script>
@endsection
