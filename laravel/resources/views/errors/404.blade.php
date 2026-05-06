@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan - Dalem Tarukan')

@section('content')
<section style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: var(--section-bg); padding: 60px 20px;">
    <div style="text-align: center; max-width: 600px;" data-aos="fade-up">
        <div style="font-family: 'Cinzel', serif; font-size: 8rem; font-weight: 900; color: var(--accent-gold); line-height: 1; margin-bottom: 20px; opacity: 0.3;">404</div>
        <h1 style="font-family: 'Cinzel', serif; font-size: 2rem; color: var(--primary-dark); margin-bottom: 15px;">Halaman Tidak Ditemukan</h1>
        <p style="color: var(--text-dim); font-size: 1.1rem; line-height: 1.7; margin-bottom: 40px;">
            Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.
        </p>
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ url('/') }}" class="btn-primary" style="text-decoration: none;">
                Kembali ke Beranda
            </a>
            <a href="{{ url('/news') }}" style="padding: 14px 30px; border: 1px solid var(--accent-gold); color: var(--accent-gold); text-decoration: none; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; transition: all 0.3s;">
                Lihat Berita
            </a>
        </div>
    </div>
</section>
@endsection
