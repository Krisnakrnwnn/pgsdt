@extends('layouts.app')

@section('title', 'Berita - Dalem Tarukan')
@section('meta_description', 'Berita terkini Para Gotra Santana Dalem Tarukan. Informasi kegiatan, pengumuman, dan perkembangan keluarga besar.')

@section('head')
  <link rel="preload" as="image" href="{{ asset('assets/heritage_hero-opt.webp') }}" fetchpriority="high">
@endsection

@section('content')
  <section class="hero" style="background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}');">
    <div class="hero-content" data-aos="fade-up">
        <h1 style="font-family: 'Cinzel', serif; margin-bottom: 10px;">Berita Dalem Tarukan</h1>
        <p style="opacity: 1; color: var(--text-light); letter-spacing: 2.5px;">Informasi dan Kegiatan Terkini</p>
    </div>
  </section>

  <section class="news-section">
    <div class="section-container">
      
      <!-- Filter & Search Bar -->
      <div class="news-page-filters" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 50px; padding-bottom: 20px; border-bottom: 1px solid rgba(212, 175, 55, 0.2);" data-aos="fade-up">
        <!-- Desktop Tabs -->
        <div class="news-filter-tabs" style="display: flex; gap: 30px; font-family: 'Cinzel', serif; font-size: 0.95rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;">
            <a href="{{ url('/news') }}{{ $searchQuery ? '?search=' . urlencode($searchQuery) : '' }}" 
               style="color: {{ $currentCategory == 'semua' ? 'var(--accent-gold-dark)' : 'var(--text-dim)' }}; position: relative; text-decoration: none; transition: color 0.3s;">
                Semua Berita
                @if($currentCategory == 'semua')
                <div style="position: absolute; bottom: -21px; left: 0; width: 100%; height: 2px; background: var(--accent-gold-dark);"></div>
                @endif
            </a>
            <a href="{{ url('/news?category=pengumuman') }}{{ $searchQuery ? '&search=' . urlencode($searchQuery) : '' }}" 
               style="color: {{ $currentCategory == 'pengumuman' ? 'var(--accent-gold-dark)' : 'var(--text-dim)' }}; position: relative; text-decoration: none; transition: color 0.3s;">
                Pengumuman
                @if($currentCategory == 'pengumuman')
                <div style="position: absolute; bottom: -21px; left: 0; width: 100%; height: 2px; background: var(--accent-gold-dark);"></div>
                @endif
            </a>
            <a href="{{ url('/news?category=kegiatan') }}{{ $searchQuery ? '&search=' . urlencode($searchQuery) : '' }}" 
               style="color: {{ $currentCategory == 'kegiatan' ? 'var(--accent-gold-dark)' : 'var(--text-dim)' }}; position: relative; text-decoration: none; transition: color 0.3s;">
                Kegiatan
                @if($currentCategory == 'kegiatan')
                <div style="position: absolute; bottom: -21px; left: 0; width: 100%; height: 2px; background: var(--accent-gold-dark);"></div>
                @endif
            </a>
        </div>
        
        <!-- Mobile Dropdown -->
        <div class="news-filter-dropdown">
            <select onchange="
                var base = this.value;
                var search = '{{ $searchQuery ? urlencode($searchQuery) : '' }}';
                window.location.href = base + (search ? (base.indexOf('?') !== -1 ? '&' : '?') + 'search=' + search : '');
            " style="width: 100%; padding: 12px 45px 12px 20px; border: 1px solid rgba(212, 175, 55, 0.4); border-radius: 30px; background: white; font-family: 'Cinzel', serif; font-size: 0.9rem; font-weight: 700; color: var(--primary-dark); appearance: none; -webkit-appearance: none; -moz-appearance: none; cursor: pointer; background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2716%27 height=%2710%27 viewBox=%270 0 16 10%27%3E%3Cpath fill=%27%23d4af37%27 d=%27M8 10L0 0h16z%27/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 18px center; background-size: 16px 10px;">
                <option value="{{ url('/news') }}" {{ $currentCategory == 'semua' ? 'selected' : '' }}>Semua Berita</option>
                <option value="{{ url('/news?category=pengumuman') }}" {{ $currentCategory == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                <option value="{{ url('/news?category=kegiatan') }}" {{ $currentCategory == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
            </select>
        </div>
        
        <!-- Search Bar -->
        <div class="news-search-container">
            <form action="{{ url('/news') }}" method="GET" class="news-search-form" id="news-search-form">
                @if($currentCategory !== 'semua')
                <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif
                <div class="news-search-wrapper">
                    <input 
                        type="text" 
                        name="search" 
                        id="news-search-input"
                        value="{{ $searchQuery }}" 
                        placeholder="Cari berita..." 
                        autocomplete="off"
                        class="news-search-input"
                    >
                    <button type="submit" aria-label="Cari berita" class="news-search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    @if($searchQuery)
                    <a href="{{ url('/news') }}{{ $currentCategory !== 'semua' ? '?category=' . $currentCategory : '' }}" 
                       class="news-search-clear" 
                       title="Hapus pencarian">✕</a>
                    @endif
                </div>
            </form>
        </div>
        
        <script>
        // Mobile: Submit on Enter key, prevent empty submission
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('news-search-form');
            const searchInput = document.getElementById('news-search-input');
            const searchBtn = document.querySelector('.news-search-btn');
            
            if (searchForm && searchInput) {
                // Prevent empty submission
                searchForm.addEventListener('submit', function(e) {
                    if (searchInput.value.trim() === '') {
                        e.preventDefault();
                        searchInput.focus();
                        return false;
                    }
                });
                
                // Desktop: Prevent button click if input is empty
                if (searchBtn) {
                    searchBtn.addEventListener('click', function(e) {
                        if (searchInput.value.trim() === '') {
                            e.preventDefault();
                            searchInput.focus();
                        }
                    });
                }
                
                // Mobile: Submit on Enter key
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (searchInput.value.trim() !== '') {
                            searchForm.submit();
                        } else {
                            searchInput.focus();
                        }
                    }
                });
            }
        });
        </script>
      </div>

      <!-- Search Results Info -->
      @if($searchQuery)
      <div style="margin-bottom: 30px; padding: 15px 20px; background: rgba(212, 175, 55, 0.1); border-left: 3px solid var(--accent-gold); border-radius: 4px;" data-aos="fade-up">
        <p style="margin: 0; color: var(--primary-dark); font-size: 0.95rem;">
          <strong>Hasil pencarian untuk:</strong> "{{ $searchQuery }}" 
          <span style="color: var(--text-dim);">({{ $news->total() }} hasil ditemukan)</span>
        </p>
      </div>
      @endif

      <div class="news-grid">
        {{-- H2 tersembunyi untuk heading hierarchy yang benar --}}
        <h2 class="sr-only">Daftar Berita</h2>
        @forelse($news as $item)
        <article class="news-card" data-aos="fade-up">
          <div class="news-img" style="overflow: hidden;">
            @if($item->images->count() > 0)
              <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" alt="{{ $item->title }}" loading="lazy" width="400" height="240" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
            @else
              <img src="{{ asset('assets/heritage_hero-opt.webp') }}" alt="Default news image" loading="lazy" width="400" height="240" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
            @endif
          </div>
          
          <div class="news-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <span class="news-tag" style="color: var(--accent-gold-dark);">{{ strtoupper($item->category ?? 'BERITA') }}</span>
                <span style="color: #374151; font-size: 0.8rem;">{{ $item->created_at->isoFormat('D MMMM Y') }}</span>
            </div>
            <h3>{{ Str::limit($item->title, 60) }}</h3>
            <p>{{ Str::limit(strip_tags($item->content), 120) }}</p>
            <a href="{{ route('news.show', $item->slug) }}" class="read-more" aria-label="Baca selengkapnya: {{ $item->title }}">
                BACA SELENGKAPNYA 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
          </div>
        </article>
        @empty
        <div style="text-align: center; grid-column: 1 / -1; padding: 100px 0;">
            <div style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;">
              @if($searchQuery)
                🔍
              @else
                🗞️
              @endif
            </div>
            <p style="color: var(--text-dim); font-size: 1.2rem;">
              @if($searchQuery)
                Tidak ada hasil untuk "{{ $searchQuery }}"
              @else
                Belum ada berita terbaru saat ini.
              @endif
            </p>
            @if($searchQuery)
            <a href="{{ url('/news') }}{{ request('category') ? '?category=' . request('category') : '' }}" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: var(--accent-gold); color: var(--primary-dark); text-decoration: none; border-radius: 30px; font-weight: 700; font-size: 0.9rem; transition: all 0.3s;">
              Lihat Semua Berita
            </a>
            @endif
        </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if($news->hasPages())
      <div style="margin-top: 60px; display: flex; justify-content: center;" data-aos="fade-up">
        {{ $news->links() }}
      </div>
      @endif
    </div>
  </section>
@endsection
