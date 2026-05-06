@extends('layouts.app')

@section('title', 'Agenda Acara - Dalem Tarukan')
@section('meta_description', 'Jadwal kegiatan dan paruman Para Gotra Santana Dalem Tarukan. Temukan agenda mendatang dan kegiatan yang telah terlaksana.')

@section('head')
  <link rel="preload" as="image" href="{{ asset('assets/heritage_hero-opt.webp') }}" fetchpriority="high">
  <style>
    /* Responsive Adjustments for Agenda List */
    @media (max-width: 768px) {
        .upcoming-event-card {
            border-radius: 0 !important;
        }
        .event-header {
            padding: 20px !important;
        }
        .event-title {
            font-size: 1.4rem !important;
        }
        .event-footer-grid {
            grid-template-columns: 1fr !important;
            gap: 0 !important;
        }
        .event-info-col {
            padding: 20px !important;
        }
        .event-map-col {
            border-left: none !important;
            border-top: 1px solid #eee;
            height: 250px !important;
        }
        .map-iframe-container {
            height: 200px !important;
        }
        .event-meta-flex {
            flex-direction: column !important;
            gap: 10px !important;
        }
        .event-actions {
            flex-direction: column !important;
            width: 100%;
        }
        .event-actions .btn-primary, 
        .event-actions .btn-outline {
            width: 100%;
            text-align: center;
            justify-content: center;
        }
        
        section[style*="padding: 80px 0"] {
            padding: 40px 0 !important;
        }
        h2[style*="font-size: 1.8rem"] {
            font-size: 1.4rem !important;
        }
    }
    
    /* Additional fixes for very small screens */
    @media (max-width: 480px) {
        .past-events-grid {
            grid-template-columns: 1fr !important;
        }
    }
  </style>
@endsection

@section('content')
  <!-- HERO -->
  <section class="hero" style="background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}');">
    <div class="hero-content" data-aos="fade-up">
      <h1>Agenda Acara</h1>
      <p>Jadwal Kegiatan dan Paruman</p>
    </div>
  </section>

  <section style="padding: 80px 0; background: var(--section-bg);">
    <div class="section-container">
      
      <!-- UPCOMING EVENTS -->
      <div style="margin-bottom: 60px;">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px;">
            <h2 style="font-family: 'Cinzel', serif; color: var(--primary-dark); margin: 0; font-size: 1.8rem;">Agenda Mendatang</h2>
            <div style="flex: 1; height: 1px; background: linear-gradient(to right, var(--accent-gold), transparent);"></div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 30px;">
            @forelse($upcomingEvents as $event)
                <div data-aos="fade-up" class="upcoming-event-card">
                    <!-- TOP: Header -->
                    <div class="event-header">
                        <div class="event-badge">AGENDA MENDATANG</div>
                        <h2 class="event-title">{{ $event->title }}</h2>
                    </div>

                    <!-- BOTTOM: Content & Map -->
                    <div class="event-footer-grid">
                        <!-- Left: Info -->
                        <div class="event-info-col">
                            <p class="event-desc">
                                {{ Str::limit(strip_tags($event->description), 250) }}
                            </p>
                            
                            <div class="event-meta-flex">
                                <div class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--accent-gold)" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM Y') }}
                                </div>
                                <div class="meta-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--accent-gold)" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event->location ?? 'Lokasi diumumkan segera' }}
                                </div>
                            </div>

                            <div class="event-actions">
                                <a href="{{ route('events.show', $event->slug) }}" class="btn-primary" style="text-decoration: none;" aria-label="Detail agenda: {{ $event->title }}">DETAIL AGENDA</a>
                                @if($event->registration_enabled)
                                    <a href="{{ route('events.register', $event->slug) }}" class="btn-outline" style="text-decoration: none; border-color: var(--accent-gold); color: var(--accent-gold);" aria-label="Daftar peserta: {{ $event->title }}">DAFTAR PESERTA</a>
                                @endif
                            </div>
                        </div>

                        <!-- Right: Map -->
                        @if($event->location_map)
                        <div class="event-map-col">
                            <div class="map-wrapper">
                                <div class="map-header">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Peta Lokasi
                                </div>
                                @php
                                    $mapQuery = $event->location_map;
                                    if (preg_match('/place\/([^\/]+)/', $event->location_map, $matches)) {
                                        $mapQuery = str_replace('+', ' ', urldecode($matches[1]));
                                    } elseif (strpos($event->location_map, 'http') === 0) {
                                        $mapQuery = $event->location;
                                    }
                                    $iframeSrc = "https://maps.google.com/maps?q=" . urlencode($mapQuery) . "&t=&z=14&ie=UTF8&iwloc=&output=embed";
                                @endphp
                                <div class="map-iframe-container" style="cursor: pointer; background: #1a1a1a;" onclick="this.innerHTML='<iframe title=\'Peta lokasi {{ $event->title }}\' width=\'100%\' height=\'100%\' style=\'border: 0; position: absolute; top: 0; left: 0; filter: contrast(1.1) brightness(0.9);\' allowfullscreen src=\'{{ $iframeSrc }}\'></iframe>'">
                                    <div style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #fff; text-align: center; padding: 20px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="var(--accent-gold)" stroke-width="1.5" style="margin-bottom: 10px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-8.25V15m-3 0V3m0 0l3 3m-3-3L9 6m3 12V21m0 0l-3-3m3 3l3-3" />
                                        </svg>
                                        <span style="font-size: 0.8rem; font-weight: 600; letter-spacing: 1px; color: var(--accent-gold-light);">LIHAT PETA LOKASI</span>
                                        <span style="font-size: 0.65rem; opacity: 0.6; margin-top: 5px;">(Klik untuk memuat peta)</span>
                                    </div>
                                </div>
                                @if(strpos($event->location_map, 'http') === 0)
                                <a href="{{ $event->location_map }}" target="_blank" class="google-maps-link" aria-label="Buka lokasi {{ $event->title }} di Google Maps" style="color: var(--accent-gold);">
                                    BUKA DI GOOGLE MAPS →
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 100px 40px; background: white; border: 1px solid #eee;">
                    <p style="color: var(--text-dim); font-size: 1.2rem; font-family: 'Cinzel', serif;">Belum ada agenda mendatang untuk saat ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination upcoming --}}
        @if($upcomingEvents->hasPages())
        <div style="margin-top: 40px; display: flex; justify-content: center;" aria-label="Navigasi halaman agenda mendatang">
            {{ $upcomingEvents->links() }}
        </div>
        @endif
      </div>

      <!-- PAST EVENTS -->
      @if($pastEvents->count() > 0)
      <div>
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 40px;">
            <h2 style="font-family: 'Cinzel', serif; color: var(--text-dim); margin: 0; font-size: 1.8rem;">Agenda Terlaksana</h2>
            <div style="flex: 1; height: 1px; background: linear-gradient(to right, #ccc, transparent);"></div>
        </div>

        <div class="past-events-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
            @foreach($pastEvents as $event)
                <div style="background: white; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); filter: grayscale(0.5); border: 1px solid #eee;">
                    <div style="padding: 25px;">
                        <div style="color: #374151; font-weight: 700; font-size: 0.85rem; margin-bottom: 10px;">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                        </div>
                        <h3 style="font-family: 'Cinzel', serif; margin-bottom: 10px; font-size: 1.1rem; color: var(--primary-dark);">{{ $event->title }}</h3>
                        <div style="color: #374151; font-size: 0.85rem; display: flex; align-items: center; gap: 5px;">
                            <span style="background: #f0f0f0; padding: 2px 8px; border: 1px solid #ccc; color: #374151;">SELESAI</span>
                            <span style="color: #374151;">• {{ $event->location ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($pastEvents->hasPages())
        <div style="margin-top: 40px; display: flex; justify-content: center;" aria-label="Navigasi halaman agenda terlaksana">
            {{ $pastEvents->links() }}
        </div>
        @endif
      </div>
      @endif

    </div>
  </section>
@endsection
