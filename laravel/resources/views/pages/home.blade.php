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
        <a href="{{ url('/member') }}" class="btn-primary" style="text-transform: none;">Daftar Anggota</a>
        <a href="{{ route('events.index') }}" class="btn-outline" style="text-transform: none;">Lihat Agenda</a>
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

  <!-- AGENDA POPUP MODAL -->
  @if(session('show_agenda_popup') && session('agenda_for_popup'))
  <div id="agenda-popup-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--primary-dark); max-width: 580px; width: 100%; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.5); border: 2px solid var(--accent-gold); animation: slideUp 0.4s ease;">
      <!-- Header -->
      <div style="background: linear-gradient(135deg, var(--accent-gold), #b8941f); padding: 28px 30px; text-align: center;">
        <div class="popup-emoji" style="font-size: 3rem; margin-bottom: 10px;">🎉</div>
        <h2 style="color: var(--primary-dark); font-size: 1.8rem; margin: 0; font-weight: 800; font-family: 'Cinzel', serif;">Selamat Bergabung!</h2>
        <p style="color: var(--primary-dark); margin: 8px 0 0 0; font-size: 1rem; opacity: 0.85; font-family: 'Inter', sans-serif;">Pendaftaran Anda berhasil dikonfirmasi</p>
      </div>
      
      <!-- Body -->
      <div style="padding: 28px 30px 30px;">
        <p style="color: var(--text-light); font-size: 1.1rem; line-height: 1.75; margin-bottom: 22px; text-align: center; font-family: 'Inter', sans-serif;">
          Saat ini ada <strong style="color: var(--accent-gold);">kegiatan agenda</strong> yang akan segera berlangsung.<br>
          Apakah Anda ingin ikut serta dalam kegiatan ini?
        </p>
        
        <!-- Agenda Info Card -->
        <div class="agenda-info-card" style="background: rgba(212, 175, 55, 0.1); border: 2px solid rgba(212, 175, 55, 0.4); padding: 22px; margin-bottom: 24px;">
          <h3 style="color: var(--accent-gold); font-size: 1.3rem; margin: 0 0 14px 0; font-weight: 700; font-family: 'Cinzel', serif; line-height: 1.3;">{{ session('agenda_for_popup')['title'] }}</h3>
          <div style="display: flex; flex-direction: column; gap: 10px; color: var(--accent-gold-light);">
            <div style="display: flex; align-items: center; gap: 10px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span style="font-family: 'Inter', sans-serif; font-size: 1rem;">{{ session('agenda_for_popup')['event_date'] }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span style="font-family: 'Inter', sans-serif; font-size: 1rem;">{{ session('agenda_for_popup')['location'] ?? 'Lokasi segera diumumkan' }}</span>
            </div>
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="popup-actions" style="display: flex; gap: 12px; flex-direction: column;">
          <button onclick="registerAgenda()" id="btn-register-agenda" class="btn-ya" style="width: 100%; background: var(--accent-gold); color: var(--primary-dark); border: none; padding: 18px 24px; font-size: 1.1rem; font-weight: 800; cursor: pointer; transition: all 0.3s; font-family: 'Cinzel', serif; text-transform: uppercase; letter-spacing: 1.5px; min-height: 60px; display: flex; align-items: center; justify-content: center; gap: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            YA, SAYA INGIN IKUT
          </button>
          <button onclick="closeAgendaPopup()" class="btn-tidak" style="width: 100%; background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.75); border: 2px solid rgba(255,255,255,0.25); padding: 16px 24px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; font-family: 'Cinzel', serif; text-transform: uppercase; letter-spacing: 1px; min-height: 56px; display: flex; align-items: center; justify-content: center; gap: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            TIDAK, TERIMA KASIH
          </button>
        </div>
        
        <p class="popup-note" style="color: rgba(255,255,255,0.45); font-size: 0.9rem; text-align: center; margin-top: 18px; line-height: 1.6; font-family: 'Inter', sans-serif;">
          Anda dapat mendaftar agenda ini nanti melalui menu <strong style="color: rgba(255,255,255,0.65);">Agenda</strong>
        </p>
      </div>
    </div>
  </div>

  <style>
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    
    #agenda-popup-modal .btn-ya:hover {
      filter: brightness(1.1);
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(212,175,55,0.4);
    }
    
    #agenda-popup-modal .btn-tidak:hover {
      background: rgba(255,255,255,0.12) !important;
      border-color: rgba(255,255,255,0.5) !important;
      color: white !important;
    }

    /* Spin animation untuk loading */
    @keyframes spin {
      from { transform: rotate(0deg); }
      to   { transform: rotate(360deg); }
    }
  </style>

  <script>
    function closeAgendaPopup() {
      const modal = document.getElementById('agenda-popup-modal');
      if (modal) {
        modal.style.opacity = '0';
        modal.style.transition = 'opacity 0.3s ease';
        setTimeout(() => modal.remove(), 300);
      }
    }
    
    function registerAgenda() {
      const btn = document.getElementById('btn-register-agenda');
      
      // Disable button dan tampilkan loading
      btn.disabled = true;
      btn.style.opacity = '0.8';
      btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite;"><path d="M21 12a9 9 0 11-6.219-8.56"/></svg>&nbsp; Sedang Mendaftar...';
      
      // Kirim request ke server
      fetch('{{ route("agenda.popup.register") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          agenda_id: {{ session('agenda_for_popup')['id'] }}
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Tampilkan pesan sukses
          btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>&nbsp; ✓ BERHASIL TERDAFTAR!';
          btn.style.background = '#27ae60';
          btn.style.color = 'white';
          btn.style.opacity = '1';
          
          setTimeout(() => {
            closeAgendaPopup();
            window.location.href = '{{ route("events.show", session("agenda_for_popup")["slug"]) }}';
          }, 1800);
        } else {
          alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
          btn.disabled = false;
          btn.style.opacity = '1';
          btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> YA, SAYA INGIN IKUT';
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> YA, SAYA INGIN IKUT';
      });
    }
    
    // Close on ESC key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeAgendaPopup();
    });
  </script>
  @endif
@endsection
