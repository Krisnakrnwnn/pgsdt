@extends('layouts.app')

@section('title', 'Verifikasi Email - Dalem Tarukan')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9; padding: 40px 20px;">
  <div style="max-width: 500px; width: 100%; background: var(--white); padding: 40px; border-radius: var(--border-radius); box-shadow: 0 10px 30px rgba(0,0,0,0.08); text-align: center;">
    
    <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; border-radius: 50%; background: rgba(241, 196, 15, 0.1); color: var(--accent-gold); margin-bottom: 20px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
    </div>

    <h2 style="margin-bottom: 15px; color: var(--text-dark);">Periksa Kotak Masuk Anda</h2>
    
    <p style="color: var(--text-dim); line-height: 1.6; margin-bottom: 30px;">
        Terima kasih telah mendaftar! Untuk mengaktifkan akun Anda, mohon verifikasi alamat email dengan mengeklik tautan yang baru saja kami kirimkan.
    </p>

    @if (session('message'))
        <div style="margin-bottom: 20px; padding: 12px; background: #e6f7eb; color: #2ecc71; border-radius: 4px; font-weight: 500;">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-bottom: 15px;">
            KIRIM ULANG EMAIL VERIFIKASI
        </button>
    </form>

    <div style="margin-top: 15px;">
        <a href="{{ url('/') }}" style="display: block; width: 100%; padding: 12px; background: #eee; color: var(--text-dark); text-decoration: none; border-radius: 4px; font-weight: 600;">
            KEMBALI KE BERANDA
        </a>
    </div>

    <div style="margin-top: 30px; text-align: center; background: #fffdf5; border: 1px solid rgba(212, 175, 55, 0.3); padding: 20px; border-radius: 8px;">
        <h4 style="margin-bottom: 10px; color: var(--primary-dark); font-size: 15px;">Salah memasukkan email?</h4>
        <p style="font-size: 13px; color: #666; margin-bottom: 15px; line-height: 1.5;">Anda dapat kembali ke halaman pendaftaran untuk memperbaiki data email Anda.</p>
        <form method="POST" action="{{ route('verification.cancel') }}">
            @csrf
            <button type="submit" style="background: var(--accent-gold); color: var(--primary-dark); border: none; padding: 10px 20px; border-radius: 4px; font-family: 'Inter', sans-serif; font-weight: 700; cursor: pointer; transition: all 0.3s; width: 100%;">
                KEMBALI KE FORM PENDAFTARAN
            </button>
        </form>
    </div>

    <div style="margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: none; border: none; color: var(--text-dim); text-decoration: underline; cursor: pointer; font-family: inherit; font-size: 14px;">
                Keluar (Logout)
            </button>
        </form>
    </div>

  </div>
</div>
@endsection
