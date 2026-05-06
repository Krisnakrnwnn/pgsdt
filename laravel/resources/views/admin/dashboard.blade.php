@extends('layouts.admin')

@section('title', 'Admin Dashboard - Dalem Tarukan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 class="page-title" style="margin: 0;">Ikhtisar Sistem</h1>
    <div style="font-size: 0.9rem; color: #888; font-weight: 500;">Hari ini: <span style="color: var(--primary-dark);">{{ now()->isoFormat('dddd, D MMMM Y') }}</span></div>
</div>
        
<!-- METRICS GRID -->
<div class="metrics-grid">
  <div class="metric-card">
    <div class="metric-icon icon-gold">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
      </svg>
    </div>
    <div class="metric-info">
      <h3>{{ $memberCount }}</h3>
      <p>Total Anggota</p>
    </div>
  </div>
  
  <div class="metric-card">
    <div class="metric-icon icon-blue">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
      </svg>
    </div>
    <div class="metric-info">
      <h3>{{ $newsCount }}</h3>
      <p>Artikel Berita</p>
    </div>
  </div>
  
  <div class="metric-card">
    <div class="metric-icon icon-green">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
    </div>
    <div class="metric-info">
      <h3>{{ $eventCount }}</h3>
      <p>Agenda Mendatang</p>
    </div>
  </div>

  <div class="metric-card">
    <div class="metric-icon icon-red">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <div class="metric-info">
      <h3>{{ $pendingCount }}</h3>
      <p>Menunggu Verifikasi</p>
    </div>
  </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px;">
    <!-- RECENT DATA TABLE -->
    <div class="table-container" style="margin-bottom: 0;">
      <div class="table-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <h2 class="table-title">Pendaftaran Anggota Terbaru</h2>
        
        <!-- DASHBOARD SEARCH -->
        <form action="{{ url('/admin') }}" method="GET" style="display: flex; gap: 8px;">
            <div style="position: relative;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari krama..." 
                       style="padding: 8px 12px; padding-left: 30px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.8rem; width: 180px;">
                <svg style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #aaa;" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <button type="submit" class="btn-primary" style="padding: 8px 15px; font-size: 0.75rem;">Cari</button>
        </form>
      </div>
      <table class="data-table" style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr>
            <th class="col-reg">
                <a href="{{ url('/admin?sort=register_number&direction=' . (request('direction') == 'asc' ? 'desc' : 'asc') . (request('search') ? '&search=' . request('search') : '')) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                    Reg {!! request('sort') == 'register_number' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                </a>
            </th>
            <th class="col-name">
                <a href="{{ url('/admin?sort=name&direction=' . (request('direction') == 'asc' ? 'desc' : 'asc') . (request('search') ? '&search=' . request('search') : '')) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                    Nama {!! request('sort') == 'name' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                </a>
            </th>
            <th class="col-wilayah">
                <a href="{{ url('/admin?sort=kabupaten&direction=' . (request('direction') == 'asc' ? 'desc' : 'asc') . (request('search') ? '&search=' . request('search') : '')) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                    Wilayah {!! request('sort') == 'kabupaten' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                </a>
            </th>
            <th class="col-status">
                <a href="{{ url('/admin?sort=member_status&direction=' . (request('direction') == 'asc' ? 'desc' : 'asc') . (request('search') ? '&search=' . request('search') : '')) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                    Status {!! request('sort') == 'member_status' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
                </a>
            </th>
            <th class="col-aksi">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentMembers as $member)
          <tr>
            <td class="col-reg" style="font-family: monospace; font-size: 0.75rem; font-weight: bold; color: var(--accent-gold);">{{ $member->register_number ?? '-' }}</td>
            <td class="col-name">
                <a href="{{ route('admin.members.show', $member->id) }}" style="text-decoration: none; display: block;">
                    <div style="font-weight: 600; color: var(--primary-dark); font-size: 0.85rem;">{{ $member->name }}</div>
                    <div style="font-size: 0.7rem; color: #888;">{{ $member->created_at->format('d M Y') }}</div>
                </a>
            </td>
            <td class="col-wilayah" style="font-size: 0.8rem;">{{ $member->kabupaten ?? '-' }}</td>
            <td class="col-status">
              @if($member->member_status == 'active')
                <span class="status-badge status-active" style="padding: 2px 8px; font-size: 10px;">Aktif</span>
              @elseif($member->member_status == 'rejected')
                <span class="status-badge status-pending" style="padding: 2px 8px; font-size: 10px; background: rgba(255, 107, 107, 0.1); color: #ff6b6b;">Ditolak</span>
              @else
                <span class="status-badge status-pending" style="padding: 2px 8px; font-size: 10px;">Menunggu</span>
              @endif
            </td>
            <td class="col-aksi">
              <div class="action-btns">
                @if($member->member_status == 'pending')
                <form action="{{ route('admin.members.verify', $member->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-icon verify" title="Setujui Anggota">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                    </button>
                </form>
                @endif
                <a href="{{ route('admin.members.show', $member->id) }}" class="btn-icon" title="Lihat Profil">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" style="text-align: center; color: var(--text-dim); padding: 40px 0; font-size: 0.85rem;">Data tidak ditemukan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- STATISTICS CARD -->
    <div class="table-container" style="margin-bottom: 0;">
        <div class="table-header">
            <h2 class="table-title">Statistik Wilayah</h2>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; gap: 18px;">
                @forelse($kabupatenStats as $stat)
                @php
                    $activeTotal = $kabupatenStats->sum('total');
                    $percentage  = $activeTotal > 0 ? ($stat->total / $activeTotal) * 100 : 0;
                @endphp
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 6px; color: #555;">
                        <span style="font-weight: 500;">{{ $stat->kabupaten }}</span>
                        <span style="font-weight: 700; color: var(--primary-dark);">{{ $stat->total }} Orang ({{ round($percentage, 1) }}%)</span>
                    </div>
                    <div style="height: 8px; background: #eee; border-radius: 4px; overflow: hidden; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                        <div style="height: 100%; background: linear-gradient(90deg, var(--accent-gold), #b8860b); width: {{ $percentage }}%; border-radius: 4px; transition: width 1s ease-in-out;"></div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 40px 0;">
                    <p style="color: #888; font-size: 0.9rem;">Belum ada data wilayah.</p>
                </div>
                @endforelse
            </div>
            
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px dashed #ddd; font-size: 0.8rem; color: #888; text-align: center;">
                Distribusi krama aktif berdasarkan data registrasi.
            </div>
        </div>
    </div>

    <!-- POPULAR EVENTS WIDGET -->
    <div class="table-container" style="margin-top: 30px;">
        <div class="table-header">
            <h2 class="table-title">Agenda Terpopuler</h2>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; gap: 20px;">
                @forelse($popularEvents as $event)
                @php
                    $fill = $event->quota > 0 ? ($event->registrations_count / $event->quota) * 100 : 0;
                @endphp
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <div style="font-weight: 600; font-size: 0.85rem; color: var(--primary-dark); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 180px;">
                            {{ $event->title }}
                        </div>
                        <div style="font-size: 0.75rem; color: var(--accent-gold); font-weight: 700;">
                            {{ $event->registrations_count }}/{{ $event->quota }}
                        </div>
                    </div>
                    <div style="height: 6px; background: #eee; border-radius: 3px; overflow: hidden;">
                        <div style="height: 100%; background: var(--primary-dark); width: {{ $fill }}%; border-radius: 3px;"></div>
                    </div>
                    <div style="font-size: 0.7rem; color: #999; margin-top: 5px;">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                    </div>
                </div>
                @empty
                <div style="text-align: center; color: #ccc; padding: 20px 0; font-size: 0.85rem;">Belum ada agenda aktif.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
