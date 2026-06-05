@extends('layouts.app')

@section('title', $newsItem->title . ' - Dalem Tarukan')
@section('meta_description', Str::limit(strip_tags($newsItem->content), 160))

@section('head')
  @if($newsItem->images->count() > 0)
    <link rel="preload" as="image" href="{{ asset('storage/' . $newsItem->images->first()->image_path) }}" fetchpriority="high">
  @else
    <link rel="preload" as="image" href="{{ asset('assets/heritage_hero-opt.webp') }}" fetchpriority="high">
  @endif
@endsection

@section('content')
  <!-- HERO -->
  <section class="hero" style="height: 300px; background-image: url('{{ $newsItem->images->count() > 0 ? asset("storage/" . $newsItem->images->first()->image_path) : asset("assets/heritage_hero-opt.webp") }}');">
    <div class="hero-content" data-aos="fade-up">
      <h1 class="news-detail-title">{{ $newsItem->title }}</h1>
      <p style="margin-top: 15px; opacity: 0.75;">
          <time datetime="{{ $newsItem->created_at->toIso8601String() }}">{{ $newsItem->created_at->isoFormat('D MMMM Y') }}</time>
          @if($newsItem->category)
              &nbsp;·&nbsp; <span style="text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; background: rgba(212,175,55,0.2); padding: 2px 10px; border-radius: 20px;">{{ $newsItem->category }}</span>
          @endif
      </p>
    </div>
  </section>

  <section class="features-section" style="padding: 60px 0;">
    <div class="news-detail-wrapper" data-aos="fade-up">
      
      <h2 class="sr-only">Konten Berita</h2>

      @if($newsItem->video_url && $newsItem->youtube_id)
      <!-- YouTube Video Player Preview Window -->
      <a href="{{ $newsItem->video_url }}" target="_blank" rel="noopener noreferrer" class="youtube-player-link" style="display: block; text-decoration: none; margin-bottom: 40px;" title="Tonton di YouTube">
          <div class="youtube-player-container" style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border: 2px solid var(--accent-gold); transition: transform 0.3s ease, box-shadow 0.3s ease;">
              <!-- YouTube Video Thumbnail -->
              <img src="https://img.youtube.com/vi/{{ $newsItem->youtube_id }}/maxresdefault.jpg" 
                   alt="Video Thumbnail" 
                   style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8; transition: opacity 0.3s ease;"
                   loading="lazy"
                   onerror="this.src='https://img.youtube.com/vi/{{ $newsItem->youtube_id }}/hqdefault.jpg'">
              
              <!-- Dark Gradient Overlay -->
              <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0.5) 100%);"></div>

              <!-- Pulsing Gold Play Button Overlay -->
              <div class="play-btn-wrapper" style="position: absolute; top: calc(50% - 25px); left: 50%; transform: translate(-50%, -50%); display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none;">
                  <div class="play-btn-circle" style="width: 80px; height: 80px; background: rgba(212, 175, 55, 0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 20px rgba(212, 175, 55, 0.6); transition: all 0.3s ease;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16" style="color: #1a1a1a; margin-left: 4px;">
                          <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                      </svg>
                  </div>
                  <span style="position: absolute; top: 100%; left: 50%; transform: translateX(-50%); margin-top: 15px; color: #fff; font-family: 'Cinzel', serif; font-size: 0.95rem; font-weight: 700; letter-spacing: 2px; text-shadow: 0 2px 4px rgba(0,0,0,0.8); text-transform: uppercase; white-space: nowrap;">Tonton di YouTube</span>
              </div>

              <!-- Mockup Player Control Bar -->
              <div class="player-controls-mock" style="position: absolute; bottom: 0; left: 0; right: 0; height: 50px; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: space-between; padding: 0 20px; border-top: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(5px); pointer-events: none;">
                  <!-- Left Controls (Play & Volume) -->
                  <div style="display: flex; align-items: center; gap: 15px; color: #fff;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                          <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.693-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                      </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M11.536 14.01A8.473 8.473 0 0 0 14 8c0-2.29-.913-4.37-2.39-5.88a.5.5 0 1 0-.707.707A7.473 7.473 0 0 1 13 8a7.473 7.473 0 0 1-2.17 5.303.5.5 0 0 0 .706.707z"/>
                          <path d="M8.707 11.182A4.486 4.486 0 0 0 10 8c0-1.25-.504-2.39-1.318-3.182a.5.5 0 1 0-.707.707C8.563 6.13 9 7.01 9 8c0 .99-.437 1.87-1.018 2.475a.5.5 0 0 0 .707.707z"/>
                          <path d="M4 4a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 1 0V8.5h2.5a.5.5 0 0 0 0-1H5V4.5A.5.5 0 0 0 4 4z"/>
                      </svg>
                      <span style="font-size: 0.8rem; opacity: 0.8; font-family: sans-serif;">Live</span>
                  </div>
                  
                  <!-- Center Progress Bar -->
                  <div style="flex-grow: 1; margin: 0 20px; height: 4px; background: rgba(255,255,255,0.2); border-radius: 2px; position: relative;">
                      <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 100%; background: var(--accent-gold); border-radius: 2px;"></div>
                  </div>

                  <!-- Right Controls (YouTube logo, fullscreen icon) -->
                  <div style="display: flex; align-items: center; gap: 15px; color: #fff;">
                      <span style="font-size: 0.75rem; opacity: 0.9; background: #ff0000; padding: 3px 8px; border-radius: 3px; font-weight: bold; display: flex; align-items: center; gap: 4px; font-family: sans-serif; letter-spacing: 0.5px;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" style="margin-bottom: 1px;">
                              <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.3 1.12.3 3.48.3 3.48s0 2.36-.3 3.48a2.01 2.01 0 0 1-1.415 1.42c-1.123.314-5.288.314-6.11.314-.822 0-4.987 0-6.11-.314a2.01 2.01 0 0 1-1.415-1.42C.3 10.36.3 8 .3 8s0-2.36.3-3.48a2.01 2.01 0 0 1 1.415-1.42c1.123-.302 5.287-.332 6.11-.335h.09zm-1.72 10.11a.76.76 0 0 0 1.185.608l4.5-3.332a.76.76 0 0 0 0-1.217l-4.5-3.331A.76.76 0 0 0 6.33 5.43v6.68z"/>
                          </svg>
                          YouTube
                      </span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                          <path d="M1.5 1a.5.5 0 0 0-.5.5v4a.5.5 0 0 1-1 0v-4A1.5 1.5 0 0 1 1.5 0h4a.5.5 0 0 1 0 1h-4zM10 .5a.5.5 0 0 1 .5-.5h4A1.5 1.5 0 0 1 16 1.5v4a.5.5 0 0 1-1 0v-4a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 1-.5-.5zM.5 10a.5.5 0 0 1 .5.5v4a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 0 14.5v-4a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v4a1.5 1.5 0 0 1-1.5 1.5h-4a.5.5 0 0 1 0-1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 1 .5-.5z"/>
                      </svg>
                  </div>
              </div>
          </div>
      </a>
      
      <style>
      @keyframes youtubePulse {
          0% { transform: scale(1); box-shadow: 0 0 20px rgba(212, 175, 55, 0.5); }
          50% { transform: scale(1.08); box-shadow: 0 0 35px rgba(212, 175, 55, 0.8); }
          100% { transform: scale(1); box-shadow: 0 0 20px rgba(212, 175, 55, 0.5); }
      }
      .youtube-player-link:hover .youtube-player-container {
          transform: translateY(-4px);
          box-shadow: 0 15px 35px rgba(212, 175, 55, 0.25);
          border-color: #fff;
      }
      .youtube-player-link:hover img {
          opacity: 0.95;
      }
      .youtube-player-link:hover .play-btn-circle {
          background: rgba(212, 175, 55, 1);
          transform: scale(1.05);
          box-shadow: 0 0 25px rgba(212, 175, 55, 0.9);
      }
      .youtube-player-link .play-btn-circle {
          animation: youtubePulse 2.5s infinite ease-in-out;
      }
      </style>
      @endif

      <div class="news-content" style="font-size: 16px; line-height: 1.8; color: var(--primary-dark); margin-bottom: 40px; white-space: pre-wrap;">{{ $newsItem->content }}</div>

      @if($newsItem->images->count() > 1)
      <h3 style="font-family: 'Cinzel', serif; font-size: 1.5rem; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid var(--accent-gold); color: var(--primary-dark);">Galeri Kegiatan</h3>
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 40px;">
        @foreach($newsItem->images as $index => $img)
            @if($index > 0)
            <div class="gallery-item" style="overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); aspect-ratio: 1/1; cursor: pointer; background: #eee;">
                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Galeri {{ $newsItem->title }} - Foto {{ $index }}" class="gallery-img" width="300" height="300" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
            </div>
            @endif
        @endforeach
      </div>
      @endif

      <div style="text-align: center;">
          <a href="{{ url('/news') }}" class="btn-primary" aria-label="Kembali ke halaman daftar berita">&larr; KEMBALI KE DAFTAR BERITA</a>
      </div>
    </div>
  </section>

@endsection
