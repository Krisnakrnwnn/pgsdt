@extends('layouts.admin')

@section('title', 'Data Anggota - Admin Dalem Tarukan')

@section('content')
<div class="table-container members-page-table">
  <div class="table-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; padding: 25px;">
    <h2 class="table-title" style="margin: 0;">Daftar Krama (Anggota) Terdaftar</h2>
    
    <!-- SEARCH BAR -->
    <form action="{{ route('admin.members.index') }}" method="GET" style="display: flex; gap: 10px; width: 100%; max-width: 500px; flex-wrap: wrap;">
        <div style="position: relative; flex: 1; min-width: 200px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NIK, No. Register..." 
                   style="width: 100%; padding: 10px 15px; padding-left: 40px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem;">
            <svg style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <select name="status" style="padding: 10px 15px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; background: white;">
            <option value="">Semua Status</option>
            <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>⏳ Menunggu</option>
            <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>✅ Aktif</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
        </select>
        <button type="submit" class="btn-primary" style="padding: 10px 20px; font-size: 0.85rem;">CARI</button>
        <a href="{{ route('admin.members.export') }}{{ request()->has('status') ? '?status='.request('status') : '' }}" class="btn-primary" style="background: var(--accent-gold); color: var(--primary-dark); text-decoration: none; padding: 10px 15px;">EXPORT CSV</a>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.members.index') }}" style="display: flex; align-items: center; justify-content: center; width: 40px; background: #eee; border-radius: 4px; color: #666; text-decoration: none;" title="Reset">✕</a>
        @endif
    </form>
  </div>
  
  @if(session('success'))
    {{-- Flash ditangani oleh global toast di layout --}}
  @endif

  <table class="data-table">
    <thead>
      <tr>
        <th class="col-register">
            <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'register_number', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                No. Register {!! request('sort') == 'register_number' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
            </a>
        </th>
        <th class="col-name">
            <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                Nama Lengkap {!! request('sort') == 'name' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
            </a>
        </th>
        <th class="col-nik">NIK</th>
        <th class="col-wilayah">
            <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'kabupaten', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                Wilayah {!! request('sort') == 'kabupaten' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
            </a>
        </th>
        <th class="col-status">
            <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'member_status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                Status {!! request('sort') == 'member_status' ? (request('direction') == 'asc' ? '↑' : '↓') : '' !!}
            </a>
        </th>
        <th class="col-aksi">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($members as $member)
      <tr>
        <td class="col-register" style="font-family: monospace; font-weight: bold; color: var(--accent-gold);">{{ $member->register_number ?? '-' }}</td>
        <td class="col-name">
            <a href="{{ route('admin.members.show', $member->id) }}" style="text-decoration: none; display: block;">
                <div style="font-weight: 600; color: var(--primary-dark);">{{ $member->name }}</div>
                <div style="font-size: 0.75rem; color: #888;">{{ $member->email }}</div>
            </a>
        </td>
        <td class="col-nik">{{ $member->nik ?? '-' }}</td>
        <td class="col-wilayah">{{ $member->kabupaten ?? '-' }}</td>
        <td class="col-status">
          @if($member->member_status == 'active')
            <span class="status-badge status-active">Aktif</span>
          @elseif($member->member_status == 'rejected')
            <span class="status-badge status-pending" style="background: rgba(255, 107, 107, 0.1); color: #ff6b6b;">Ditolak</span>
          @else
            <span class="status-badge status-pending">Menunggu</span>
          @endif
        </td>
        <td class="col-aksi">
          <div class="action-btns">
            @if($member->member_status == 'pending')
            <form action="{{ route('admin.members.verify', $member->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-icon verify" title="Verifikasi Cepat">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </button>
            </form>
            @endif
                <a href="{{ route('admin.members.show', $member->id) }}" class="btn-icon" title="Lihat Profil Lengkap">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </a>
                <a href="{{ route('admin.members.edit', $member->id) }}" class="btn-icon" title="Edit Data">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </a>
            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini secara permanen?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-icon delete" title="Hapus">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
          <td colspan="6" style="text-align: center; padding: 50px 0; color: #888;">
              <div style="font-size: 2rem; margin-bottom: 10px;">🔍</div>
              Data anggota tidak ditemukan.
          </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- PAGINATION -->
  <div class="pagination-wrapper" style="padding: 30px 20px; border-top: 1px solid #eee; display: flex; flex-direction: column; align-items: center; gap: 15px;">
      <div style="width: 100%;">
          {{ $members->links() }}
      </div>
      <div class="pagination-info">
          Menampilkan {{ $members->firstItem() }} sampai {{ $members->lastItem() }} dari total {{ $members->total() }} krama.
      </div>
  </div>
</div>
@endsection
