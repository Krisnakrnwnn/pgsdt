@extends('layouts.app')

@section('title', 'Warisan Budaya & Sejarah - Dalem Tarukan')
@section('meta_description', 'Sejarah Ida Bhatara Dalem Tarukan, Pura Pedharman Pusat di Pulasari Bangli, dan pelestarian warisan budaya Bali oleh Para Gotra Santana.')

@section('head')
  <link rel="preload" as="image" href="{{ asset('assets/heritage_hero-opt.webp') }}" fetchpriority="high">
@endsection

@section('content')
  <!-- HERO SECTION -->
  <section class="hero" style="background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}');">
    <div class="hero-content" data-aos="fade-up">
        <h1 style="font-family: 'Cinzel', serif; font-size: clamp(2rem, 8vw, 3.5rem); margin-bottom: 10px;">Sejarah & Warisan</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Melestarikan Babad dan Naskah Lontar Leluhur</p>
    </div>
  </section>

  <!-- HISTORY SECTION -->
  <section style="padding: 80px 0; background: var(--section-bg);">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 40px;">
        <div class="heritage-grid">
            <div data-aos="fade-right">
                <div style="width: 60px; height: 3px; background: var(--accent-gold); margin-bottom: 30px;"></div>
                <h2 style="font-family: 'Cinzel', serif; font-size: clamp(1.8rem, 5vw, 2.5rem); color: var(--primary-dark); margin-bottom: 30px;">Sejarah Ida Bhatara Dalem Tarukan</h2>
                <div style="color: #555; line-height: 1.8; font-size: clamp(1rem, 2vw, 1.1rem); text-align: justify;">
                    <p style="margin-bottom: 20px;">
                        Ida Bhatara Dalem Tarukan merupakan sosok agung dalam sejarah kerajaan Bali. Sebagai putra dari Raja Bali yang termasyhur, beliau memilih jalan pengabdian dan kesederhanaan yang mendalam, meninggalkan kemewahan istana untuk menyatu dengan rakyat.
                    </p>
                    <p style="margin-bottom: 20px;">
                        Jejak sejarah beliau tersebar di berbagai wilayah di Bali, mulai dari Desa Tarukan hingga ke pelosok-pelosok desa di mana keturunan beliau (Para Gotra Santana) menetap dan berkembang hingga saat ini.
                    </p>
                    <p>
                        Nilai-nilai kepemimpinan, kerendahhatian, dan persaudaraan yang beliau wariskan menjadi fondasi kuat bagi keluarga besar kita dalam menjaga kerukunan dan kelestarian adat budaya Bali.
                    </p>
                </div>
            </div>
            <div class="heritage-image-wrapper" data-aos="fade-left">
                <div class="heritage-image-border"></div>
                <div class="heritage-image-container">
                    <img src="{{ asset('assets/heritage_hero-opt.webp') }}" alt="Arca Heritage" width="500" height="625" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; filter: sepia(0.3) brightness(0.8);">
                </div>
            </div>
        </div>
    </div>
  </section>

  <!-- PURA PEDHARMAN SECTION -->
  <section style="padding: 80px 0; background: white;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 40px;">
        <div style="text-align: center; margin-bottom: 60px;" data-aos="fade-up">
            <h2 style="font-family: 'Cinzel', serif; font-size: clamp(1.8rem, 5vw, 2.5rem); color: var(--primary-dark);">Pura Pedharman Pusat</h2>
            <p style="color: #555; margin-top: 15px; font-size: clamp(0.95rem, 2vw, 1.1rem);">Pusat spiritual dan pemersatu seluruh krama Para Gotra Santana Dalem Tarukan.</p>
        </div>

        <div class="pura-card" data-aos="fade-up">
            <div class="pura-image">
                <img src="{{ asset('assets/heritage_hero-opt.webp') }}" alt="Pura Pulasari" width="600" height="450" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(1) opacity(0.7);">
            </div>
            <div class="pura-content">
                <h3 style="font-family: 'Cinzel', serif; font-size: clamp(1.4rem, 3vw, 1.8rem); color: var(--primary-dark); margin-bottom: 20px;">Pulasari, Bangli</h3>
                <p style="color: #666; line-height: 1.8; margin-bottom: 30px; font-size: clamp(0.95rem, 2vw, 1.05rem);">
                    Pura Pedharman Pusat Ida Bhatara Dalem Tarukan yang berlokasi di Pulasari, Bangli merupakan tempat suci utama bagi seluruh keturunan beliau. Di sinilah seluruh krama dari berbagai penjuru berkumpul untuk melaksanakan bakti pujawali dan mempererat tali persaudaraan.
                </p>
                <div class="pura-stats">
                    <div class="pura-stat-item">
                        <div style="color: var(--accent-gold); font-size: clamp(1.2rem, 3vw, 1.5rem); font-weight: 700; font-family: 'Cinzel', serif;">1969</div>
                        <div style="font-size: clamp(0.65rem, 1.5vw, 0.75rem); color: #555; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Tahun Pemugaran</div>
                    </div>
                    <div class="pura-stat-divider"></div>
                    <div class="pura-stat-item">
                        <div style="color: var(--accent-gold); font-size: clamp(1.2rem, 3vw, 1.5rem); font-weight: 700; font-family: 'Cinzel', serif;">WUKU</div>
                        <div style="font-size: clamp(0.65rem, 1.5vw, 0.75rem); color: #555; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Sungsang</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>

  <!-- CTA SECTION -->
  <section style="padding: 60px 0; background: var(--accent-gold); text-align: center;">
    <div style="max-width: 700px; margin: 0 auto; padding: 0 20px; text-align: center;" data-aos="zoom-in">
        <h2 style="font-family: 'Cinzel', serif; font-size: clamp(1.5rem, 4vw, 2.2rem); color: var(--primary-dark); margin-bottom: 20px;">Kontribusi Untuk Sejarah Kita</h2>
        <p style="color: var(--primary-dark); opacity: 0.8; max-width: 600px; margin: 0 auto 40px; font-weight: 500; font-size: clamp(0.95rem, 2vw, 1.05rem);">Jika Anda memiliki informasi, naskah, atau foto bersejarah mengenai keluarga besar, mari berkontribusi untuk melengkapi pusat dokumentasi kita.</p>
        <a href="mailto:pgsdtpusat1969@gmail.com" class="btn-primary" style="background: var(--primary-dark); color: var(--accent-gold); border: none; padding: 14px 35px; border-radius: 0px; text-decoration: none; font-weight: 700; font-size: clamp(0.75rem, 2vw, 0.9rem); display: inline-block;">HUBUNGI SEKRETARIAT</a>
    </div>
  </section>
@endsection
