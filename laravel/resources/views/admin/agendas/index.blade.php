@extends('layouts.admin')

@section('title', 'Kelola Agenda - Admin Dalem Tarukan')

@section('content')
<div class="table-container agendas-page-table">
  <div class="table-header" style="padding: 25px;">
    <h2 class="table-title" style="margin: 0;">Manajemen Agenda & Acara</h2>
    <a href="{{ route('admin.agendas.create') }}" class="btn-primary" style="text-decoration: none;">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
      BUAT AGENDA BARU
    </a>
  </div>
  
  @if(session('success'))
    {{-- Flash ditangani oleh global toast di layout --}}
  @endif

  <table class="data-table">
    <thead>
      <tr>
        <th class="col-image" style="width: 100px;">Gambar</th>
        <th class="col-detail">Detail Acara</th>
        <th class="col-schedule" style="width: 150px;">Jadwal & Lokasi</th>
        <th class="col-registration" style="width: 150px;">Registrasi</th>
        <th class="col-status" style="width: 120px;">Status</th>
        <th class="col-aksi" style="width: 200px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($agendas as $agenda)
      <tr>
        <td class="col-image">
            @if($agenda->image_path)
                <img src="{{ asset('storage/' . $agenda->image_path) }}" alt="{{ $agenda->title }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
            @else
                <div style="width: 80px; height: 50px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 10px; font-weight: 700;">NO IMAGE</div>
            @endif
        </td>
        <td class="col-detail">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <div style="font-weight: 700; color: var(--primary-dark); font-size: 1rem;">{{ $agenda->title }}</div>
                @if($agenda->is_featured)
                    <span style="background: rgba(241, 196, 15, 0.2); color: #d35400; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">UTAMA</span>
                @endif
            </div>
            <div style="font-size: 0.75rem; color: #888;">{{ Str::limit(strip_tags($agenda->description), 60) }}</div>
        </td>
        <td class="col-schedule">
            <div style="font-weight: 600; font-size: 0.85rem;">{{ \Carbon\Carbon::parse($agenda->event_date)->format('d M Y') }}</div>
            <div style="font-size: 0.75rem; color: var(--text-dim);">{{ $agenda->location ?? 'Lokasi Belum Diatur' }}</div>
        </td>
        <td class="col-registration">
            @if($agenda->registration_enabled && $agenda->quota > 0)
            <div style="display: flex; flex-direction: column; gap: 4px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem;">
                    <span>Terisi:</span>
                    <span style="font-weight: 700;">{{ $agenda->confirmed_registrations_count }}/{{ $agenda->quota }}</span>
                </div>
                <div style="height: 6px; background: #eee; border-radius: 3px; overflow: hidden;">
                    @php $percent = min(($agenda->confirmed_registrations_count / $agenda->quota) * 100, 100); @endphp
                    <div style="height: 100%; background: {{ $percent >= 100 ? '#e74c3c' : 'var(--accent-gold)' }}; width: {{ $percent }}%; transition: width 0.3s;"></div>
                </div>
            </div>
            @else
                <span style="font-size: 0.75rem; color: var(--text-dim);">{{ $agenda->registration_enabled ? 'Tanpa Kuota' : 'Ditutup' }}</span>
            @endif
        </td>
        <td class="col-status">
          @if($agenda->status == 'upcoming')
            <span class="status-badge status-active" style="background: rgba(52, 152, 219, 0.15); color: #2980b9;">MENDATANG</span>
          @elseif($agenda->status == 'completed')
            <span class="status-badge status-draft" style="background: rgba(149, 165, 166, 0.15); color: #7f8c8d;">SELESAI</span>
          @else
            <span class="status-badge status-pending" style="background: rgba(231, 76, 60, 0.15); color: #c0392b;">BATAL</span>
          @endif
        </td>
        <td class="col-aksi">
          <div class="action-btns">
            <form action="{{ route('admin.agendas.set-featured', $agenda->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-icon" title="{{ $agenda->is_featured ? 'Hapus dari Utama' : 'Jadikan Agenda Utama' }}" 
                        style="color: {{ $agenda->is_featured ? '#f39c12' : '#ddd' }};">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="{{ $agenda->is_featured ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.07 6.323a1 1 0 00.95.69h6.643c.969 0 1.371 1.24.588 1.81l-5.374 3.903a1 1 0 00-.364 1.118l2.07 6.323c.3.921-.755 1.688-1.54 1.118l-5.374-3.903a1 1 0 00-1.175 0l-5.374 3.903c-.785.57-1.838-.197-1.539-1.118l2.07-6.323a1 1 0 00-.364-1.118L2.292 11.75c-.783-.57-.38-1.81.588-1.81h6.643a1 1 0 00.95-.69l2.07-6.323z" />
                    </svg>
                </button>
            </form>

            <a href="{{ route('admin.agendas.registrations', $agenda->id) }}" class="btn-icon" title="Daftar Peserta" style="color: #3498db;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </a>
            <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="btn-icon" title="Edit">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </a>
            <form action="{{ route('admin.agendas.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus agenda ini?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-icon delete" title="Hapus">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" style="text-align: center; padding: 60px 0; color: var(--text-dim);">
            <div style="font-size: 3rem; margin-bottom: 10px;">📅</div>
            Belum ada agenda acara.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($agendas->hasPages())
  <div style="padding: 20px 25px; border-top: 1px solid #eee;">
      {{ $agendas->links() }}
  </div>
  @endif
</div>
@endsection
