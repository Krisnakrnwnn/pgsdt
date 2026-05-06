@extends('layouts.app')

@section('title', $event->title . ' - Agenda Dalem Tarukan')
@section('meta_description', Str::limit($event->description, 160))

@section('head')
    <!-- Preload critical LCP image -->
    <link rel="preload" as="image" href="{{ $event->image_path ? asset('storage/' . $event->image_path) : asset('assets/heritage_hero-opt.webp') }}" fetchpriority="high">
    
    <!-- Inline critical CSS for hero to prevent layout shift -->
    <style>
        .hero {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            position: relative;
            text-align: center;
            color: white;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 0 20px;
        }
    </style>
@endsection

@section('content')
  <!-- HERO -->
  <section class="hero" style="background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('{{ $event->image_path ? asset('storage/' . $event->image_path) : asset('assets/heritage_hero-opt.webp') }}'); border-radius: 0px;">
    <div class="hero-content">
      <div style="margin-bottom: 15px;">
        @php
          $statusLabel = match($event->status) {
              'upcoming'  => 'AGENDA MENDATANG',
              'completed' => 'TELAH TERLAKSANA',
              'cancelled' => 'DIBATALKAN',
              default     => strtoupper($event->status),
          };
          $statusStyle = $event->status === 'upcoming'
              ? 'background: rgba(212, 175, 55, 0.25); color: #5a4a12; border: 1px solid #5a4a12; font-weight: 800;'
              : 'background: rgba(0,0,0,0.5); color: #fff; font-weight: 800;';
        @endphp
        <span style="padding: 5px 15px; border-radius: 0px; font-size: 0.8rem; font-weight: 700; {{ $statusStyle }}">
            {{ $statusLabel }}
        </span>
      </div>
      <h1 style="font-size: clamp(2rem, 8vw, 3.5rem); margin-bottom: 20px; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">{{ $event->title }}</h1>
      <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px 30px; font-size: 0.9rem; letter-spacing: 1px; color: #fff;">
        <span style="display: flex; align-items: center; gap: 5px;">📅 {{ \Carbon\Carbon::parse($event->event_date)->isoFormat('D MMMM Y') }}</span>
        <span style="display: flex; align-items: center; gap: 5px;">📍 {{ $event->location ?? 'Segera Dikonfirmasi' }}</span>
        <span style="display: flex; align-items: center; gap: 5px;">⏰ {{ \Carbon\Carbon::parse($event->event_date)->format('H:i') }} WITA</span>
      </div>
    </div>
  </section>

  <section class="event-content" style="padding: 60px 0;">
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        <!-- Back Link -->
        <a href="{{ route('events.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #222; text-decoration: none; font-weight: 700; margin-bottom: 30px; font-size: 0.9rem; border-bottom: 2px solid var(--accent-gold);" aria-label="Kembali ke halaman daftar agenda">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            KEMBALI KE AGENDA
        </a>

        <div style="display: grid; grid-template-columns: 1fr; gap: 40px; margin-top: -30px; position: relative; z-index: 10;">
            @if($event->registration_enabled)
            <!-- Meta Grid Card -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1px; background: #eee; border: 1px solid #eee; border-radius: 0px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <div style="background: white; padding: 25px; text-align: center;">
                    <span style="display: block; font-size: 0.75rem; color: #333; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 1px;">Kapasitas / Kuota</span>
                    <strong style="color: var(--primary-dark); font-size: 1.2rem; font-family: 'Cinzel', serif;">{{ $event->quota }} Orang</strong>
                </div>
                <div style="background: white; padding: 25px; text-align: center;">
                    <span style="display: block; font-size: 0.75rem; color: #333; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 1px;">Pendaftar Saat Ini</span>
                    <strong style="color: var(--primary-dark); font-size: 1.2rem; font-family: 'Cinzel', serif;">{{ $event->registrations_count ?? 0 }} Peserta</strong>
                </div>
                <div style="background: white; padding: 25px; text-align: center;">
                    <span style="display: block; font-size: 0.75rem; color: #333; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 1px;">Status Pendaftaran</span>
                    @php
                        $isFull = ($event->registrations_count ?? 0) >= $event->quota;
                    @endphp
                    <strong style="color: {{ $isFull ? '#c0392b' : '#1e8449' }}; font-size: 1.2rem; font-family: 'Cinzel', serif;">{{ $isFull ? 'PENUH' : 'TERSEDIA' }}</strong>
                </div>
            </div>
            @endif

            <!-- Main Content Card -->
            <div style="background: white; padding: 50px; border-radius: 0px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee;">
                <h2 style="font-family: 'Cinzel', serif; color: var(--primary-dark); margin-bottom: 25px; font-size: 1.6rem; border-bottom: 3px solid var(--accent-gold); display: inline-block; padding-bottom: 8px;">Deskripsi Kegiatan</h2>
                <div style="white-space: pre-line; line-height: 1.8; color: #333; font-size: 1.15rem;">
                    {{ $event->description }}
                </div>
            </div>

            <!-- Map Card -->
            @if($event->location_map)
            <div style="background: white; padding: 30px; border-radius: 0px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h2 style="font-family: 'Cinzel', serif; color: var(--primary-dark); margin: 0; font-size: 1.4rem; display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="var(--accent-gold)" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lokasi Kegiatan
                    </h3>
                    @if(strpos($event->location_map, 'http') === 0)
                    <a href="{{ $event->location_map }}" target="_blank" style="color: #856a15; text-decoration: none; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 5px; border: 1px solid #856a15; padding: 5px 12px;" aria-label="Buka lokasi di Google Maps">
                        BUKA DI GOOGLE MAPS 
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                    @endif
                </div>

                @php
                    $mapQuery = $event->location_map;
                    // Coba ekstrak nama tempat jika itu link google maps panjang
                    if (preg_match('/place\/([^\/]+)/', $event->location_map, $matches)) {
                        $mapQuery = str_replace('+', ' ', urldecode($matches[1]));
                    } elseif (strpos($event->location_map, 'http') === 0) {
                        // Jika link pendek, gunakan teks lokasi sebagai cadangan query peta
                        $mapQuery = $event->location;
                    }
                @endphp

                <div id="map-loader-container" class="map-container" style="position: relative; padding-bottom: 40%; height: 0; overflow: hidden; border: 1px solid #eee; background: #f9f9f9;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; text-align: center;">
                        <p style="color: var(--primary-dark); font-weight: 600; margin-bottom: 15px; font-size: 1rem;">Klik untuk memuat peta interaktif</p>
                        <button onclick="loadInteractiveMap()" style="background: var(--accent-gold); color: var(--primary-dark); border: none; padding: 12px 25px; font-weight: 700; cursor: pointer; font-size: 0.85rem; letter-spacing: 1px;">MUAT PETA</button>
                    </div>
                    <script>
                        function loadInteractiveMap() {
                            const container = document.getElementById('map-loader-container');
                            const q = "{{ urlencode($mapQuery) }}";
                            container.innerHTML = `<iframe 
                                title="Peta Lokasi {{ $event->title }}"
                                width="100%" 
                                height="100%" 
                                style="position: absolute; top: 0; left: 0; border: 0;" 
                                allowfullscreen 
                                src="https://maps.google.com/maps?q=${q}&t=&z=15&ie=UTF8&iwloc=&output=embed">
                            </iframe>`;
                        }
                    </script>
                </div>
            </div>
            @endif

            <!-- Rundown Card -->
            @if($event->itinerary)
            <div style="background: var(--card-bg); padding: 50px; border-radius: 0px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(212, 175, 55, 0.1); position: relative; overflow: hidden;">
                <!-- Subtle Ornament Background -->
                <div style="position: absolute; top: -20px; right: -20px; opacity: 0.05; pointer-events: none;">
                    <svg width="200" height="200" viewBox="0 0 100 100">
                        <path d="M0,50 Q25,0 50,50 T100,50" fill="none" stroke="var(--accent-gold)" stroke-width="0.5" />
                    </svg>
                </div>

                <h2 style="font-family: 'Cinzel', serif; color: var(--primary-dark); margin-bottom: 35px; font-size: 1.6rem; display: flex; align-items: center; gap: 20px;">
                    <span style="width: 50px; height: 2px; background: var(--accent-gold);"></span>
                    Jadwal Acara / Rundown
                    <span style="width: 50px; height: 2px; background: var(--accent-gold);"></span>
                </h2>
                
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: separate; border-spacing: 0; border: 1px solid #eee; border-radius: 0px;">
                        <thead>
                            <tr style="background: var(--primary-dark); color: white;">
                                <th style="padding: 20px 15px; text-align: center; width: 70px; font-size: 0.95rem; letter-spacing: 1px; border-bottom: 2px solid var(--accent-gold);">NO</th>
                                <th style="padding: 20px 15px; text-align: left; width: 200px; font-size: 0.95rem; letter-spacing: 1px; border-bottom: 2px solid var(--accent-gold);">WAKTU (WITA)</th>
                                <th style="padding: 20px 15px; text-align: left; font-size: 0.95rem; letter-spacing: 1px; border-bottom: 2px solid var(--accent-gold);">KEGIATAN / ACARA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $itineraryData = [];
                                try {
                                    $itineraryData = json_decode($event->itinerary, true);
                                } catch (\Exception $e) {
                                    $itineraryData = [];
                                }

                                if (!is_array($itineraryData)) {
                                    foreach(explode("\n", $event->itinerary) as $line) {
                                        if(trim($line)) {
                                            $parts = explode('-', $line, 2);
                                            $itineraryData[] = [
                                                'start' => trim($parts[0]),
                                                'end' => '',
                                                'activity' => isset($parts[1]) ? trim($parts[1]) : '-'
                                            ];
                                        }
                                    }
                                }
                            @endphp

                            @forelse($itineraryData as $index => $item)
                                <tr style="{{ $index % 2 == 0 ? 'background: #fff;' : 'background: #fafafa;' }}">
                                    <td style="padding: 20px 15px; border-bottom: 1px solid #eee; text-align: center; color: #000; font-weight: 700;">{{ $index + 1 }}</td>
                                    <td style="padding: 20px 15px; border-bottom: 1px solid #eee; font-weight: 800; color: #000; font-family: 'Cinzel', serif;">
                                        @if(!empty($item['start']) && !empty($item['end']))
                                            {{ $item['start'] }} – {{ $item['end'] }}
                                        @else
                                            {{ $item['start'] ?? $item['time'] ?? '-' }}
                                        @endif
                                    </td>
                                    <td style="padding: 20px 15px; border-bottom: 1px solid #eee; color: #222; white-space: pre-line; line-height: 1.7;">{{ $item['activity'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="padding: 40px; text-align: center; color: #555; font-style: italic;">Belum ada jadwal yang diatur.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Footer CTA Card -->
            @if($event->registration_enabled)
            <div style="text-align: center; padding: 50px; background: var(--primary-dark); color: white; border-radius: 0px; border-bottom: 5px solid var(--accent-gold);">
                @php
                    $isRegistered = false;
                    if (auth()->check()) {
                        $isRegistered = \App\Models\AgendaRegistration::where('user_id', auth()->id())
                            ->where('agenda_id', $event->id)
                            ->exists();
                    }
                @endphp

                @if($isRegistered)
                    <h3 style="font-family: 'Cinzel', serif; font-size: 1.8rem; margin-bottom: 15px; color: #27ae60;">Anda Sudah Terdaftar</h3>
                    <p style="color: #e0e0e0; font-size: 1.1rem; margin-bottom: 0; max-width: 600px; margin-inline: auto;">Terima kasih telah mendaftar pada agenda ini. Kami tunggu kehadiran Anda.</p>
                @else
                    <h3 style="font-family: 'Cinzel', serif; font-size: 1.8rem; margin-bottom: 15px;">Tertarik untuk Bergabung?</h3>
                    <p style="color: #e0e0e0; font-size: 1.1rem; margin-bottom: 30px; max-width: 600px; margin-inline: auto;">Jadilah bagian dari kegiatan akbar ini dan pererat tali persaudaraan dalam keluarga besar.</p>
                    <a href="{{ route('events.register', $event->slug) }}" class="btn-primary" style="padding: 15px 40px; font-size: 1rem;" aria-label="Daftar untuk mengikuti {{ $event->title }}">DAFTAR SEKARANG</a>
                @endif
            </div>
            @endif
        </div>
    </div>
  </section>
@endsection
