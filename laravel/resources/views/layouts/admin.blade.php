<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard - Dalem Tarukan')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="{{ asset('assets/admin.css') }}?v={{ time() }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/Logo.png') }}">
</head>
<body>

  <div class="admin-layout">
    
    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="sidebar">
      <div class="sidebar-header">
        <a href="{{ url('/') }}" class="sidebar-brand">
          <img src="{{ asset('assets/Logo.png') }}" alt="Logo">
          <span class="brand-font">PGSDT</span>
        </a>
      </div>
      
      <div class="sidebar-menu">
        <ul class="menu-list">
          <li class="menu-item">
            <a href="{{ url('/admin') }}" class="menu-link {{ request()->is('admin') ? 'active' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              Dashboard
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('admin.members.index') }}" class="menu-link {{ request()->is('admin/members*') ? 'active' : '' }}" style="position: relative;">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              Data Anggota
              @php
                $sidebarPendingCount = \App\Models\User::where('role', 'member')->where('member_status', 'pending')->count();
              @endphp
              @if($sidebarPendingCount > 0)
                <span style="position: absolute; right: 15px; background: #ff4757; color: white; font-size: 10px; font-weight: 700; min-width: 18px; height: 18px; border-radius: 9px; display: flex; align-items: center; justify-content: center; padding: 0 5px;">
                    {{ $sidebarPendingCount }}
                </span>
              @endif
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('admin.news.index') }}" class="menu-link {{ request()->is('admin/news*') ? 'active' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4" />
              </svg>
              Kelola Berita
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('admin.agendas.index') }}" class="menu-link {{ request()->is('admin/agendas*') ? 'active' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Kelola Agenda
            </a>
          </li>
        </ul>
      </div>
      
      <div class="sidebar-footer">
        <a href="{{ url('/') }}" class="logout-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          Keluar Sistem
        </a>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
      
      <!-- TOP HEADER -->
      <header class="admin-header">
        <div class="header-left">
          <button class="menu-toggle" id="menuToggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <div class="search-bar">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" placeholder="Cari data anggota atau berita...">
          </div>
        </div>
        
        <div class="header-right">
          <div class="user-profile">
            <div class="user-info">
              <span class="user-name">{{ auth()->user()->name }}</span>
              <span class="user-role">{{ ucfirst(auth()->user()->role) }}</span>
            </div>
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
          </div>
        </div>
      </header>

      <!-- CONTENT WRAPPER -->
      <div class="content-wrapper">
        @yield('content')
      </div>

      <!-- GLOBAL FLASH MESSAGES (Admin) -->
      @if(session('success') || session('error') || session('info') || session('warning'))
      <div id="admin-flash-toast" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; max-width: 380px;">
        @if(session('success'))
        <div style="display: flex; align-items: flex-start; gap: 12px; background: #fff; border-left: 4px solid #27ae60; padding: 16px 20px; border-radius: 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); margin-bottom: 10px;">
          <span style="font-size: 1.2rem;">✅</span>
          <div style="flex: 1;">
            <div style="font-weight: 700; color: #1a1a1a; font-size: 0.9rem; margin-bottom: 2px;">Berhasil</div>
            <div style="color: #555; font-size: 0.85rem; line-height: 1.4;">{{ session('success') }}</div>
          </div>
          <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.1rem; padding: 0 0 0 8px;">✕</button>
        </div>
        @endif
        @if(session('error'))
        <div style="display: flex; align-items: flex-start; gap: 12px; background: #fff; border-left: 4px solid #e74c3c; padding: 16px 20px; border-radius: 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); margin-bottom: 10px;">
          <span style="font-size: 1.2rem;">❌</span>
          <div style="flex: 1;">
            <div style="font-weight: 700; color: #1a1a1a; font-size: 0.9rem; margin-bottom: 2px;">Gagal</div>
            <div style="color: #555; font-size: 0.85rem; line-height: 1.4;">{{ session('error') }}</div>
          </div>
          <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.1rem; padding: 0 0 0 8px;">✕</button>
        </div>
        @endif
        @if(session('info'))
        <div style="display: flex; align-items: flex-start; gap: 12px; background: #fff; border-left: 4px solid #3498db; padding: 16px 20px; border-radius: 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); margin-bottom: 10px;">
          <span style="font-size: 1.2rem;">ℹ️</span>
          <div style="flex: 1;">
            <div style="font-weight: 700; color: #1a1a1a; font-size: 0.9rem; margin-bottom: 2px;">Informasi</div>
            <div style="color: #555; font-size: 0.85rem; line-height: 1.4;">{{ session('info') }}</div>
          </div>
          <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.1rem; padding: 0 0 0 8px;">✕</button>
        </div>
        @endif
        @if(session('warning'))
        <div style="display: flex; align-items: flex-start; gap: 12px; background: #fff; border-left: 4px solid #f39c12; padding: 16px 20px; border-radius: 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); margin-bottom: 10px;">
          <span style="font-size: 1.2rem;">⚠️</span>
          <div style="flex: 1;">
            <div style="font-weight: 700; color: #1a1a1a; font-size: 0.9rem; margin-bottom: 2px;">Perhatian</div>
            <div style="color: #555; font-size: 0.85rem; line-height: 1.4;">{{ session('warning') }}</div>
          </div>
          <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #aaa; cursor: pointer; font-size: 1.1rem; padding: 0 0 0 8px;">✕</button>
        </div>
        @endif
      </div>
      <script>
        setTimeout(function() {
          var t = document.getElementById('admin-flash-toast');
          if (t) { t.style.transition = 'opacity 0.5s'; t.style.opacity = '0'; setTimeout(function(){ t.remove(); }, 500); }
        }, 5000);
      </script>
      @endif
    </main>
  </div>

  <script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });

    document.addEventListener('click', (e) => {
      if (window.innerWidth <= 992) {
        if (!sidebar.contains(e.target) && !menuToggle.contains(e.target) && sidebar.classList.contains('open')) {
          sidebar.classList.remove('open');
        }
      }
    });
  </script>
  @yield('scripts')
</body>
</html>
