@extends('layouts.admin')

@section('title', 'Daftar Peserta - ' . $agenda->title)

@section('content')
<div style="margin-bottom: 25px;">
    <a href="{{ route('admin.agendas.index') }}" style="text-decoration: none; color: var(--text-dim); display: flex; align-items: center; gap: 8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar Agenda
    </a>
</div>

<div class="table-container">
  <div class="table-header" style="flex-direction: column; align-items: flex-start; gap: 15px; padding: 25px;">
    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
        <div>
            <h2 class="table-title" style="margin: 0;">Daftar Peserta: {{ $agenda->title }}</h2>
            <p style="color: var(--text-dim); margin: 5px 0 0; font-size: 0.9rem;">
                Total: <strong>{{ $registrations->total() }}</strong> peserta
                @if(request('status')) | Filter: <strong>{{ ucfirst(request('status')) }}</strong> @endif
            </p>
        </div>
    </div>

    {{-- Filter by status --}}
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.agendas.registrations', $agenda->id) }}"
           style="padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-decoration: none;
                  background: {{ !request('status') ? 'var(--primary-dark)' : '#eee' }};
                  color: {{ !request('status') ? 'white' : '#555' }};">
            Semua
        </a>
        <a href="{{ route('admin.agendas.registrations', $agenda->id) }}?status=confirmed"
           style="padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-decoration: none;
                  background: {{ request('status') == 'confirmed' ? '#27ae60' : '#eee' }};
                  color: {{ request('status') == 'confirmed' ? 'white' : '#555' }};">
            ✅ Dikonfirmasi
        </a>
        <a href="{{ route('admin.agendas.registrations', $agenda->id) }}?status=pending"
           style="padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-decoration: none;
                  background: {{ request('status') == 'pending' ? '#f39c12' : '#eee' }};
                  color: {{ request('status') == 'pending' ? 'white' : '#555' }};">
            ⏳ Menunggu
        </a>
        <a href="{{ route('admin.agendas.registrations', $agenda->id) }}?status=cancelled"
           style="padding: 6px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; text-decoration: none;
                  background: {{ request('status') == 'cancelled' ? '#e74c3c' : '#eee' }};
                  color: {{ request('status') == 'cancelled' ? 'white' : '#555' }};">
            ❌ Dibatalkan
        </a>
    </div>
  </div>

  @if(session('success'))
    {{-- Flash ditangani oleh global toast di layout --}}
  @endif

  <table class="data-table">
    <thead>
      <tr>
        <th>Nama Lengkap</th>
        <th>Email</th>
        <th>Nomor Telpon</th>
        <th>Tanggal Daftar</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($registrations as $reg)
      <tr>
        <td style="font-weight: 700;">{{ $reg->name }}</td>
        <td>{{ $reg->user->email ?? '-' }}</td>
        <td>{{ $reg->phone ?? '-' }}</td>
        <td>{{ $reg->created_at->format('d/m/Y H:i') }}</td>
        <td>
          <form action="{{ route('admin.agendas.registrations.status', $reg->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <select name="status" onchange="if(confirm('Ubah status pendaftaran ini?')) this.form.submit(); else this.value='{{ $reg->status }}';"
                    style="padding: 5px 8px; border-radius: 4px; border: 1px solid #ddd; font-size: 0.82rem; cursor: pointer;
                           background: {{ $reg->status == 'confirmed' ? '#d4edda' : ($reg->status == 'cancelled' ? '#f8d7da' : '#fff8e1') }};">
                <option value="pending"    {{ $reg->status == 'pending'    ? 'selected' : '' }}>⏳ Menunggu</option>
                <option value="confirmed"  {{ $reg->status == 'confirmed'  ? 'selected' : '' }}>✅ Dikonfirmasi</option>
                <option value="cancelled"  {{ $reg->status == 'cancelled'  ? 'selected' : '' }}>❌ Dibatalkan</option>
            </select>
          </form>
        </td>
        <td>
          <div class="action-btns">
            <form action="{{ route('admin.agendas.registrations.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran ini?');" style="display:inline;">
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
        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-dim);">
            Belum ada peserta yang mendaftar.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($registrations->hasPages())
  <div style="padding: 20px 25px; border-top: 1px solid #eee;">
      {{ $registrations->links() }}
  </div>
  @endif
</div>
@endsection
