@extends('layouts.app')

@section('head')
  <!-- Preload hero image untuk LCP lebih cepat -->
  <link rel="preload" as="image" href="{{ asset('assets/heritage_hero-opt.webp') }}" fetchpriority="high" type="image/webp">
@endsection

@section('title', 'Dalem Tarukan - Official Profile')
@section('meta_description', 'Portal resmi Para Gotra Santana Dalem Tarukan. Bergabunglah dalam memperkuat persaudaraan dan melestarikan warisan leluhur Bali.')

@section('content')
  <!-- HERO -->
  <section class="hero hero-fullscreen" style="background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}'); border-radius: 0px;">
    <div class="hero-content hero-box-mobile" data-aos="fade-up" data-aos-duration="1000" style="background: rgba(10, 31, 28, 0.4); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 4px; padding: 50px 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
      <h1 style="text-transform: none;">Para Gotra Santana Dalem Tarukan</h1>
      <p>Memperkuat Persaudaraan, Melestarikan Warisan Leluhur</p>
      <div class="hero-btns" style="margin-top: 20px;">
        @guest
          <a href="{{ url('/member') }}" class="btn-primary" style="text-transform: none;">Daftar Anggota</a>
        @endguest
      </div>
    </div>
  </section>

  <!-- DYNAMIC EVENT SECTION -->
  @if($latestEvent)
  <section class="musyawarah-section">
    <div class="section-container">
      <div class="musyawarah-card" data-aos="fade-up">
        <div class="musyawarah-content">
          <span class="badge" style="border-radius: 0px; text-transform: none;">Agenda Utama</span>
          <h2 style="font-family: 'Cinzel', serif; text-transform: none;">{{ $latestEvent->title }}</h2>
          <p>{{ Str::limit(strip_tags($latestEvent->description), 200) }}</p>
          <div class="event-details">
            <span style="display: flex; align-items: center; gap: 8px;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> {{ \Carbon\Carbon::parse($latestEvent->event_date)->isoFormat('dddd, D MMMM Y') }}</span>
            <span style="display: flex; align-items: center; gap: 8px;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> {{ $latestEvent->location ?? 'Lokasi segera diumumkan' }}</span>
          </div>
          <div class="btn-group">
              <a href="{{ route('events.show', $latestEvent->slug) }}" class="btn-primary" style="border-radius: 0px; text-decoration: none; text-transform: none;">Lihat Detail</a>
              @if($latestEvent->registration_enabled)
                <a href="{{ route('events.register', $latestEvent->slug) }}" class="btn-outline" style="border-radius: 0px; text-decoration: none; border-color: var(--accent-gold); color: var(--accent-gold); text-transform: none;">Registrasi Peserta</a>
              @endif
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- WHY JOIN SECTION -->
  <section class="features-section">
    <div class="section-container">
      <div class="section-header" data-aos="fade-up">
        <h2 style="border-radius: 0px;">MENGAPA BERGABUNG?</h2>
      </div>
      <div class="news-grid">
        <article class="news-card" data-aos="fade-up" data-aos-delay="100" style="border-radius: 0px;">
          <div class="news-body">
            <span class="news-tag" style="border-radius: 0px;">COMMUNITY</span>
            <h3>Jejaring Persaudaraan</h3>
            <p>Terhubung dengan ribuan sanak saudara Dalem Tarukan di seluruh Bali dan luar daerah melalui platform digital terintegrasi.</p>
          </div>
        </article>
        <article class="news-card" data-aos="fade-up" data-aos-delay="200" style="border-radius: 0px;">
          <div class="news-body">
            <span class="news-tag" style="border-radius: 0px;">HERITAGE</span>
            <h3>Akses Silsilah & Sejarah</h3>
            <p>Dapatkan akses eksklusif ke dokumen sejarah, naskah lontar, dan database silsilah keluarga (Babad) yang terverifikasi.</p>
          </div>
        </article>
        <article class="news-card" data-aos="fade-up" data-aos-delay="300" style="border-radius: 0px;">
          <div class="news-body">
            <span class="news-tag" style="border-radius: 0px;">BENEFIT</span>
            <h3>Kartu Anggota Digital</h3>
            <p>Identitas resmi sebagai krama Dalem Tarukan yang memberikan kemudahan dalam pendataan dan kegiatan sosial keagamaan.</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- LATEST NEWS PREVIEW -->
  <section class="news-section">
    <div class="section-container">
      <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; text-align: left;" data-aos="fade-up">
        <h2 style="margin: 0;">BERITA TERBARU</h2>
        <a href="{{ url('/news') }}" class="view-all">LIHAT SEMUA <span class="arrow">→</span></a>
      </div>
      <div class="news-grid">
        @forelse($latestNews as $item)
        <article class="news-card" data-aos="fade-up" style="border-radius: 0px;">
          @if(is_object($item) && $item->images && $item->images->count() > 0)
          <div class="news-img" style="background-image: url('{{ asset('storage/' . $item->images->first()->image_path) }}'); border-radius: 0px;"></div>
          @else
          <div class="news-img" style="background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}'); border-radius: 0px;"></div>
          @endif
          <div class="news-body">
            <span class="news-tag" style="border-radius: 0px;">BERITA</span>
            <h3>{{ Str::limit($item->title, 50) }}</h3>
            <p>{{ Str::limit(strip_tags($item->content), 80) }}</p>
            <a href="{{ route('news.show', $item->slug) }}" class="read-more" style="text-transform: none;">
                Baca Selengkapnya 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
          </div>
        </article>
        @empty
        <p style="text-align: center; grid-column: 1 / -1; color: var(--text-dim);">Belum ada berita terbaru.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
