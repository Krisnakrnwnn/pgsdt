@extends('layouts.app')

@section('title', 'Terjadi Kesalahan - Dalem Tarukan')

@section('content')
<section style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: var(--section-bg); padding: 60px 20px;">
    <div style="text-align: center; max-width: 600px;" data-aos="fade-up">
        <div style="font-family: 'Cinzel', serif; font-size: 8rem; font-weight: 900; color: var(--accent-gold); line-height: 1; margin-bottom: 20px; opacity: 0.3;">500</div>
        <h1 style="font-family: 'Cinzel', serif; font-size: 2rem; color: var(--primary-dark); margin-bottom: 15px;">Terjadi Kesalahan Server</h1>
        <p style="color: var(--text-dim); font-size: 1.1rem; line-height: 1.7; margin-bottom: 40px;">
            Maaf, terjadi kesalahan pada server kami. Tim teknis kami sedang menangani masalah ini.
        </p>
        <a href="{{ url('/') }}" class="btn-primary" style="text-decoration: none;">
            Kembali ke Beranda
        </a>
    </div>
</section>
@endsection
