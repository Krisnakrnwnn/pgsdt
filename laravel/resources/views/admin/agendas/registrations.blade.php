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
        <div>
            <a href="{{ route('admin.agendas.registrations.export', $agenda->id) }}{{ request()->has('status') ? '?status='.request('status') : '' }}" class="btn-primary" style="background: var(--accent-gold); color: var(--primary-dark); text-decoration: none; padding: 10px 15px; display: inline-flex; align-items: center; gap: 5px; border-radius: 4px; font-weight: 600; font-size: 0.85rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                EXPORT EXCEL
            </a>
        </div>
    </div>

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
        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-dim);">
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
