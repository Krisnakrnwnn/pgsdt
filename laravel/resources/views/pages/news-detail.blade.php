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
