<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dalem Tarukan - Official Profile')</title>
  <meta name="description" content="@yield('meta_description', 'Portal resmi Para Gotra Santana Dalem Tarukan. Memperkuat persaudaraan dan melestarikan warisan leluhur Bali.')">

  <!-- Open Graph -->
  <meta property="og:title" content="@yield('title', 'Dalem Tarukan - Official Profile')">
  <meta property="og:description" content="@yield('meta_description', 'Portal resmi Para Gotra Santana Dalem Tarukan. Memperkuat persaudaraan dan melestarikan warisan leluhur Bali.')">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Dalem Tarukan">
  <meta property="og:image" content="{{ asset('assets/Logo-192.png') }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta http-equiv="X-Content-Type-Options" content="nosniff">
  <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">

  <link rel="canonical" href="{{ url()->current() }}">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('title', 'Dalem Tarukan - Official Profile')">
  <meta name="twitter:description" content="@yield('meta_description', 'Portal resmi Para Gotra Santana Dalem Tarukan.')">
  <meta name="twitter:image" content="{{ asset('assets/Logo-192.png') }}">

  <!-- PWA -->
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#d4af37">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="PGSDT">
  <link rel="apple-touch-icon" href="{{ asset('assets/Logo-192.png') }}">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/Logo-60.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/Logo-192.png') }}">

  <!-- Self-hosted Fonts (Inlined to prevent render-blocking) -->
  <link rel="preload" href="/fonts/cinzel-latin.woff2" as="font" type="font/woff2" crossorigin>
  
  <!-- Resource Hints for Performance -->
  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="preconnect" href="{{ asset('') }}" crossorigin>
  
  <style>
    @font-face {
      font-family: 'Cinzel';
      font-style: normal;
      font-weight: 400 900;
      font-display: swap;
      src: url('/fonts/cinzel-latin.woff2') format('woff2');
      unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    
    /* Critical CSS - Prevent layout shift */
    body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
    .navbar { position: sticky; top: 0; z-index: 1000; background: rgba(10,31,28,0.95); backdrop-filter: blur(10px); }
  </style>

  @vite(['resources/css/app.css'])

  <!-- Animation CSS native — menggantikan AOS library 25KB -->
  <style>
    [data-aos] {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    [data-aos].aos-animate {
      opacity: 1;
      transform: translateY(0);
    }
  </style>

  @yield('head')</head>
<body>
  <!-- Skip link untuk keyboard navigation -->
  <a href="#main-content" style="position: absolute; top: -100px; left: 0; background: var(--accent-gold); color: var(--primary-dark); padding: 8px 16px; font-weight: 700; z-index: 10000; transition: top 0.2s;" onfocus="this.style.top='0'" onblur="this.style.top='-100px'">Lewati ke konten utama</a>

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="{{ url('/') }}" class="nav-brand">
        <picture>
          <source srcset="{{ asset('assets/Logo-60.webp') }}" type="image/webp">
          <img src="{{ asset('assets/Logo-60.png') }}" alt="Dalem Tarukan Logo" class="brand-logo" width="40" height="40" loading="eager">
        </picture>
        <span class="brand-name">Dalem Tarukan</span>
      </a>
      
      <div class="nav-menu" id="nav-menu">
        @php
            $navLinks = [
                '/'        => 'Beranda',
                'news'     => 'Berita',
                'events'   => 'Agenda',
                'heritage' => 'Warisan',
            ];
        @endphp

        @foreach($navLinks as $path => $label)
            <a href="{{ url($path) }}" class="{{ request()->is($path === '/' ? '/' : $path) ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
        
        @guest
          <a href="{{ url('/member') }}" class="nav-cta {{ request()->is('member') ? 'active' : '' }}">Daftar</a>
        @endguest

        @auth
          @if(auth()->user()->role === 'admin')
            <a href="{{ url('/admin') }}" class="nav-cta">Dashboard Admin</a>
          @endif
          
          <div style="position: relative; display: flex; align-items: center; margin-left: 10px; padding-left: 20px; border-left: 1px solid rgba(255,255,255,0.2);">
            <!-- Profile Trigger -->
            <button onclick="toggleProfileDropdown()" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 0;">
              <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-gold), #b8860b); color: var(--primary-dark); display: flex; justify-content: center; align-items: center; font-weight: 700; font-size: 1rem; font-family: 'Cinzel', serif; box-shadow: 0 2px 10px rgba(212,175,55,0.3); overflow: hidden;">
                @if(auth()->user()->image_path)
                  <img src="{{ asset('storage/' . auth()->user()->image_path) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="profile-dropdown" style="display: none; position: absolute; top: calc(100% + 15px); right: 0; width: 180px; background: white; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border: 1px solid #eee; overflow: hidden; z-index: 100;">
                <a href="{{ route('profile') }}" style="display: block; padding: 12px 16px; color: var(--primary-dark); text-decoration: none; font-size: 0.9rem; font-family: 'Cinzel', serif; font-weight: 700; border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='white'">Profil Saya</a>
                
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                  @csrf
                  <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; color: #e74c3c; cursor: pointer; font-size: 0.9rem; font-family: 'Cinzel', serif; font-weight: 700; transition: background 0.2s;" onmouseover="this.style.background='#fff0f0'" onmouseout="this.style.background='white'">Logout</button>
                </form>
            </div>
          </div>
        @endauth
      </div>

      <!-- Mobile Hamburger Button -->
      <button id="mobile-toggle" class="mobile-toggle" aria-label="Buka Menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </nav>
    
    <!-- Mobile Menu Backdrop (click to close) -->
    <div id="mobile-backdrop" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100vh; background: rgba(0, 0, 0, 0.5); z-index: 998; backdrop-filter: blur(2px);" onclick="closeMobileMenu()"></div>
    
    <!-- Mobile Menu Dropdown -->
    <div id="mobile-overlay" style="display: none; position: fixed; top: 0; right: 0; left: auto; width: auto; max-width: 260px; height: 100vh; background: rgba(10,31,28,0.98); z-index: 999; flex-direction: column; align-items: flex-start; gap: 18px; padding: 100px 20px 30px; box-shadow: -5px 0 25px rgba(0,0,0,0.5); border-left: 1px solid rgba(212, 175, 55, 0.3); overflow-y: auto;">
      <!-- Close Button -->
      <button onclick="closeMobileMenu()" style="position: absolute; top: 20px; right: 20px; background: none; border: none; color: var(--accent-gold); cursor: pointer; padding: 8px; display: flex; align-items: center; justify-content: center; z-index: 1000; transition: transform 0.2s;" onmouseover="this.style.transform='rotate(90deg)'" onmouseout="this.style.transform='rotate(0deg)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
      
      @foreach($navLinks as $path => $label)
          <a href="{{ url($path) }}" style="color: var(--text-light); text-decoration: none; font-size: 0.95rem; font-family: 'Cinzel', serif; letter-spacing: 1.5px; text-transform: uppercase; transition: color 0.3s; width: 100%; {{ request()->is($path === '/' ? '/' : $path) ? 'color: var(--accent-gold);' : '' }}" onclick="closeMobileMenu()">{{ $label }}</a>
      @endforeach
      @guest
          <a href="{{ url('/member') }}" style="border: 1px solid var(--accent-gold); color: var(--accent-gold); padding: 8px 20px; font-family: 'Cinzel', serif; font-size: 0.8rem; letter-spacing: 1.5px; text-transform: uppercase; text-decoration: none; margin-top: 8px; transition: all 0.3s; width: 100%; text-align: center; box-sizing: border-box;" onclick="closeMobileMenu()">DAFTAR</a>
      @endguest
      @auth
          <a href="{{ route('profile') }}" style="color: var(--accent-gold); text-decoration: none; font-size: 0.85rem; font-family: 'Cinzel', serif; letter-spacing: 1.5px; width: 100%;" onclick="closeMobileMenu()">PROFIL SAYA</a>
          <form method="POST" action="{{ route('logout') }}" style="margin: 0; width: 100%;">
              @csrf
              <button type="submit" style="background: rgba(255,0,0,0.15); border: 1px solid rgba(255,0,0,0.4); color: #ff6b6b; cursor: pointer; font-family: 'Cinzel', serif; font-size: 0.75rem; font-weight: 600; padding: 8px 20px; letter-spacing: 1.5px; width: 100%;" onclick="closeMobileMenu()">LOGOUT</button>
          </form>
      @endauth
    </div>
  </nav>


  <main id="main-content">
    @yield('content')
  </main>

  <!-- GLOBAL FLASH MESSAGES -->
  @if(session('success') || session('error') || session('info') || session('warning'))
  <div id="flash-toast" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; max-width: 380px;">
    @if(session('success'))
    <div class="flash-msg" style="display: flex; align-items: flex-start; gap: 12px; background: #fff; border-left: 4px solid #27ae60; padding: 16px 20px; border-radius: 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);">
      <span style="font-size: 1.2rem; flex-shrink: 0;">✅</span>
      <div>
        <div style="font-weight: 700; color: #1a1a1a; font-size: 0.9rem; margin-bottom: 2px;">Berhasil</div>
        <div style="color: #555; font-size: 0.85rem; line-height: 1.4;">{{ session('success') }}</div>
      </div>
      <button onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.1rem; flex-shrink: 0; padding: 0 0 0 8px;">✕</button>
    </div>
    @endif
    @if(session('error'))
    <div class="flash-msg" style="display: flex; align-items: flex-start; gap: 12px; background: #fff; border-left: 4px solid #e74c3c; padding: 16px 20px; border-radius: 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);">
      <span style="font-size: 1.2rem; flex-shrink: 0;">❌</span>
      <div>
        <div style="font-weight: 700; color: #1a1a1a; font-size: 0.9rem; margin-bottom: 2px;">Gagal</div>
        <div style="color: #555; font-size: 0.85rem; line-height: 1.4;">{{ session('error') }}</div>
      </div>
      <button onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.1rem; flex-shrink: 0; padding: 0 0 0 8px;">✕</button>
    </div>
    @endif
    @if(session('info'))
    <div class="flash-msg" style="display: flex; align-items: flex-start; gap: 12px; background: #fff; border-left: 4px solid #3498db; padding: 16px 20px; border-radius: 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);">
      <span style="font-size: 1.2rem; flex-shrink: 0;">ℹ️</span>
      <div>
        <div style="font-weight: 700; color: #1a1a1a; font-size: 0.9rem; margin-bottom: 2px;">Informasi</div>
        <div style="color: #555; font-size: 0.85rem; line-height: 1.4;">{{ session('info') }}</div>
      </div>
      <button onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.1rem; flex-shrink: 0; padding: 0 0 0 8px;">✕</button>
    </div>
    @endif
    @if(session('warning'))
    <div class="flash-msg" style="display: flex; align-items: flex-start; gap: 12px; background: #fff; border-left: 4px solid #f39c12; padding: 16px 20px; border-radius: 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);">
      <span style="font-size: 1.2rem; flex-shrink: 0;">⚠️</span>
      <div>
        <div style="font-weight: 700; color: #1a1a1a; font-size: 0.9rem; margin-bottom: 2px;">Perhatian</div>
        <div style="color: #555; font-size: 0.85rem; line-height: 1.4;">{{ session('warning') }}</div>
      </div>
      <button onclick="this.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.1rem; flex-shrink: 0; padding: 0 0 0 8px;">✕</button>
    </div>
    @endif
  </div>

  @endif

  <!-- FOOTER -->
  @if(!request()->is('login'))
  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-brand" data-aos="fade-up">
        <picture>
          <source srcset="{{ asset('assets/Logo-192.webp') }}" type="image/webp">
          <img src="{{ asset('assets/Logo-192.png') }}" alt="Dalem Tarukan Logo" class="footer-logo" width="60" height="60" loading="lazy">
        </picture>
        <h3>Dalem Tarukan</h3>
        <p style="color: rgba(255,255,255,0.9);">Memperkuat Persaudaraan, Melestarikan Warisan Leluhur.</p>
      </div>
      
      <div class="footer-links" data-aos="fade-up" data-aos-delay="100">
        <h4>Navigasi</h4>
        <ul>
          <li><a href="{{ url('/') }}" style="color: rgba(255,255,255,0.9);">Beranda</a></li>
          <li><a href="{{ url('/news') }}" style="color: rgba(255,255,255,0.9);">Berita</a></li>
          <li><a href="{{ url('/events') }}" style="color: rgba(255,255,255,0.9);">Agenda</a></li>
          <li><a href="{{ url('/heritage') }}" style="color: rgba(255,255,255,0.9);">Warisan</a></li>
          <li><a href="{{ url('/member') }}" style="color: rgba(255,255,255,0.9);">Daftar Anggota</a></li>
        </ul>
      </div>

      <div class="footer-contact" data-aos="fade-up" data-aos-delay="200">
        <h4>Hubungi Kami</h4>
        <ul>
          <li style="color: rgba(255,255,255,0.9);"><span style="display: flex; align-items: center; justify-content: center; width: 24px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg></span> <span>Sekretariat : Pura Pedharman Pusat Ida Bhatara Dalem Tarukan,<br>Pulasari, Peninjoan, Kec. Tembuku, Kab. Bangli</span></li>
          <li style="color: rgba(255,255,255,0.9);"><span style="display: flex; align-items: center; justify-content: center; width: 24px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></span> pgsdtpusat1969@gmail.com</li>
          <li>
            <span style="display: flex; align-items: center; justify-content: center; width: 24px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></span> 
            <div style="display: flex; flex-direction: column; gap: 5px;">
              <a href="tel:+6281283144560" target="_blank" rel="noopener" style="color: #ffffff; text-decoration: underline; font-weight: 700;">081283144560</a>
              <a href="tel:+628123919488" target="_blank" rel="noopener" style="color: #ffffff; text-decoration: underline; font-weight: 700;">08123919488</a>
            </div>
          </li>
        </ul>
      </div>

      <div class="footer-social" data-aos="fade-up" data-aos-delay="300">
        <h4>Media Sosial</h4>
        <div class="social-icons">
          <a href="#" class="social-icon" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
            </svg>
          </a>
          <a href="#" class="social-icon" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
            </svg>
          </a>
          <a href="#" class="social-icon" aria-label="YouTube">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33 2.78 2.78 0 0 0 1.94 2c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path>
              <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
            </svg>
          </a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p style="color: rgba(255,255,255,0.85);">&copy; {{ date('Y') }} Para Gotra Santana Dalem Tarukan. All Rights Reserved.</p>
    </div>
  </footer>
  @endif





  
  @vite(['resources/js/app.js'])
  
  @auth
  @php
      // Check for upcoming agenda if user is a member and hasn't dismissed the popup
      if (auth()->user()->role === 'member' && !session('agenda_popup_dismissed')) {
          if (!session()->has('show_agenda_popup')) {
              $upcomingAgenda = \App\Models\Agenda::where('status', 'upcoming')
                  ->where('registration_enabled', true)
                  ->where('event_date', '>=', now()->startOfDay())
                  ->orderBy('event_date', 'asc')
                  ->first();

              if ($upcomingAgenda) {
                  $isAlreadyRegistered = \App\Models\AgendaRegistration::where('agenda_id', $upcomingAgenda->id)
                      ->where('user_id', auth()->id())
                      ->exists();

                  if (!$isAlreadyRegistered) {
                      session()->put('show_agenda_popup', true);
                      session()->put('agenda_for_popup', [
                          'id' => $upcomingAgenda->id,
                          'title' => $upcomingAgenda->title,
                          'slug' => $upcomingAgenda->slug,
                          'event_date' => $upcomingAgenda->event_date->isoFormat('D MMMM Y'),
                          'location' => $upcomingAgenda->location,
                      ]);
                  }
              }
          }
      }
      
      $showPopup = session('show_agenda_popup');
      $agendaData = session('agenda_for_popup');
  @endphp

  @if($showPopup && $agendaData && is_array($agendaData))
  <!-- AGENDA POPUP MODAL (Global) -->
  <div id="agenda-popup-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 10001; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--primary-dark); max-width: 500px; width: 100%; border-radius: 0px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.5); border: 1px solid var(--accent-gold); animation: slideUpPopup 0.4s ease;">
      
      <div style="padding: 30px;">
        <h2 style="color: var(--accent-gold); font-size: 1.5rem; margin: 0 0 15px 0; text-align: center; font-family: 'Cinzel', serif; font-weight: 700;">Agenda Mendatang</h2>
        <p style="color: var(--text-light); font-size: 1rem; line-height: 1.6; margin-bottom: 25px; text-align: center;">
          Apakah Anda ingin mengikuti agenda ini?
        </p>
        
        <div style="background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.3); padding: 25px; margin-bottom: 30px; border-radius: 0px;">
          <h3 style="color: var(--accent-gold); font-size: 1.4rem; margin: 0 0 15px 0; font-weight: 700; font-family: 'Cinzel', serif;">{{ $agendaData['title'] ?? 'Agenda Mendatang' }}</h3>
          <div style="display: flex; flex-direction: column; gap: 12px; color: var(--accent-gold-light); font-size: 1.05rem;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span>{{ $agendaData['event_date'] ?? '-' }}</span>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>{{ $agendaData['location'] ?? 'Lokasi segera diumumkan' }}</span>
            </div>
          </div>
        </div>
        
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
          <button onclick="registerAgendaPopup()" id="btn-register-agenda-popup" style="flex: 1; min-width: 200px; background: var(--accent-gold); color: var(--primary-dark); border: none; padding: 18px 24px; font-size: 1.15rem; font-weight: 800; cursor: pointer; transition: all 0.3s; font-family: 'Cinzel', serif; border-radius: 0px; text-transform: uppercase; letter-spacing: 1px;">
            YA, SAYA IKUT
          </button>
          <button onclick="closeAgendaPopupGlobal()" style="flex: 1; min-width: 200px; background: transparent; color: var(--text-light); border: 2px solid rgba(255,255,255,0.3); padding: 18px 24px; font-size: 1.15rem; font-weight: 700; cursor: pointer; transition: all 0.3s; font-family: 'Cinzel', serif; border-radius: 0px; text-transform: uppercase; letter-spacing: 1px;">
            TIDAK, TERIMA KASIH
          </button>
        </div>
      </div>
    </div>
  </div>

  <style>
    @keyframes slideUpPopup { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    #agenda-popup-modal button:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
    @media (max-width: 768px) {
      #agenda-popup-modal > div { max-width: 95%; margin: 0 10px; }
      #agenda-popup-modal h2 { font-size: 1.5rem !important; }
      #agenda-popup-modal h3 { font-size: 1.2rem !important; }
      #agenda-popup-modal p { font-size: 1.1rem !important; }
      #agenda-popup-modal button { font-size: 1.1rem !important; padding: 16px 20px !important; min-width: 100% !important; }
    }
  </style>

  <script>
    function closeAgendaPopupGlobal() {
      const modal = document.getElementById('agenda-popup-modal');
      if (modal) {
        modal.style.opacity = '0';
        modal.style.transition = 'opacity 0.3s ease';
        setTimeout(() => modal.remove(), 300);
      }
      @if(Route::has('agenda.popup.dismiss'))
      fetch('{{ route("agenda.popup.dismiss") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
      });
      @endif
    }
    
    function registerAgendaPopup() {
      const btn = document.getElementById('btn-register-agenda-popup');
      if (!btn) return;
      const originalText = btn.innerHTML;
      btn.disabled = true;
      btn.innerHTML = 'Memproses...';
      
      @if(Route::has('agenda.popup.register'))
      fetch('{{ route("agenda.popup.register") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ agenda_id: {{ $agendaData['id'] ?? 0 }} })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          btn.innerHTML = '✓ BERHASIL';
          btn.style.background = '#4caf50';
          setTimeout(() => {
            closeAgendaPopupGlobal();
            @if(isset($agendaData['slug']))
            window.location.href = '{{ route("events.show", $agendaData["slug"]) }}';
            @endif
          }, 1500);
        } else {
          alert(data.message || 'Terjadi kesalahan.');
          btn.disabled = false;
          btn.innerHTML = originalText;
        }
      })
      .catch(error => {
        alert('Terjadi kesalahan.');
        btn.disabled = false;
        btn.innerHTML = originalText;
      });
      @endif
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeAgendaPopupGlobal();
    });
  </script>
  @endif
  @endauth

  @yield('scripts')
</body>
</html>
