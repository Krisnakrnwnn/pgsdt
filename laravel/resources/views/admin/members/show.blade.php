@extends('layouts.admin')

@section('title', 'Detail Anggota - ' . $member->name)

@section('content')
<div class="admin-container member-detail-page" style="padding: 30px;">
    
    <!-- HEADER WITH BACK BUTTON -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="{{ route('admin.members.index') }}" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #f0f0f0; border-radius: 8px; text-decoration: none; color: var(--primary-dark); transition: all 0.3s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="page-title" style="margin: 0;">Detail Anggota</h1>
                <p style="color: #888; font-size: 0.85rem; margin-top: 5px;">Informasi lengkap data krama</p>
            </div>
        </div>
        
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @if($member->member_status == 'pending')
            <form action="{{ route('admin.members.verify', $member->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-primary" style="padding: 10px 20px; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Verifikasi Anggota
                </button>
            </form>
            @endif
            
            <a href="{{ route('admin.members.edit', $member->id) }}" class="btn-outline" style="padding: 10px 20px; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Data
            </a>
        </div>
    </div>

    <!-- MEMBER DETAIL GRID -->
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; max-width: 1200px;">
        
        <!-- LEFT COLUMN: PHOTO & STATUS -->
        <div>
            <!-- PHOTO CARD -->
            <div class="table-container member-card" style="text-align: center; padding: 30px;">
                <div style="width: 200px; height: 260px; margin: 0 auto 20px; border-radius: 12px; overflow: hidden; background: #f5f5f5; display: flex; align-items: center; justify-content: center; border: 2px solid #eee;">
                    @if($member->image_path)
                        <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none" viewBox="0 0 24 24" stroke="#ccc" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    @endif
                </div>
                
                <h3 style="color: var(--primary-dark); margin-bottom: 8px; font-size: 1.3rem;">{{ $member->name }}</h3>
                <p style="color: #888; font-size: 0.85rem; margin-bottom: 15px;">{{ $member->email }}</p>
                
                <!-- STATUS BADGE -->
                <div style="margin-bottom: 20px;">
                    @if($member->member_status == 'active')
                        <span class="status-badge status-active" style="padding: 6px 16px; font-size: 0.85rem;">✓ Aktif</span>
                    @elseif($member->member_status == 'rejected')
                        <span class="status-badge" style="padding: 6px 16px; font-size: 0.85rem; background: rgba(255, 107, 107, 0.1); color: #ff6b6b;">✕ Ditolak</span>
                    @else
                        <span class="status-badge status-pending" style="padding: 6px 16px; font-size: 0.85rem;">⏳ Menunggu</span>
                    @endif
                </div>
                
                <!-- REGISTRATION INFO -->
                <div style="border-top: 1px solid #eee; padding-top: 20px; text-align: left;">
                    <div style="margin-bottom: 12px;">
                        <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">No. Register</span>
                        <span style="color: var(--accent-gold); font-family: monospace; font-size: 1rem; font-weight: 700;">{{ $member->register_number ?? '-' }}</span>
                    </div>
                    <div style="margin-bottom: 12px;">
                        <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Tanggal Bergabung</span>
                        <span style="color: var(--primary-dark); font-size: 0.9rem; font-weight: 600;">{{ $member->created_at->format('d M Y') }}</span>
                    </div>
                    <div>
                        <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Email Terverifikasi</span>
                        @if($member->email_verified_at)
                            <span style="color: #27ae60; font-size: 0.85rem; font-weight: 600;">✓ Ya</span>
                        @else
                            <span style="color: #e74c3c; font-size: 0.85rem; font-weight: 600;">✕ Belum</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: DETAILED INFO -->
        <div>
            <!-- PERSONAL DATA -->
            <div class="table-container member-card" style="margin-bottom: 20px;">
                <div class="table-header">
                    <h2 class="table-title">Data Personal</h2>
                </div>
                <div style="padding: 25px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px 30px;">
                        <div>
                            <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Nama Lengkap</span>
                            <span style="color: var(--primary-dark); font-size: 1rem; font-weight: 600; display: block;">{{ $member->name }}</span>
                        </div>
                        <div>
                            <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">NIK</span>
                            <span style="color: var(--primary-dark); font-size: 1rem; font-weight: 600; font-family: monospace; display: block;">{{ $member->nik }}</span>
                        </div>
                        <div>
                            <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Email</span>
                            <span style="color: var(--primary-dark); font-size: 0.95rem; font-weight: 600; display: block; word-break: break-all;">{{ $member->email }}</span>
                        </div>
                        <div>
                            <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">No. WhatsApp</span>
                            @if($member->phone)
                                <a href="tel:{{ $member->phone }}" style="color: var(--primary-dark); font-size: 0.95rem; font-weight: 600; text-decoration: none; display: block;">{{ $member->phone }}</a>
                            @else
                                <span style="color: #ccc; font-size: 0.95rem;">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- LOCATION DATA -->
            <div class="table-container member-card" style="margin-bottom: 20px;">
                <div class="table-header">
                    <h2 class="table-title">Data Wilayah</h2>
                </div>
                <div style="padding: 25px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px 30px;">
                        <div>
                            <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Kabupaten</span>
                            <span style="color: var(--primary-dark); font-size: 1rem; font-weight: 600; display: block;">{{ $member->kabupaten ?? '-' }}</span>
                        </div>
                        <div>
                            <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Kecamatan</span>
                            <span style="color: var(--primary-dark); font-size: 1rem; font-weight: 600; display: block;">{{ $member->kecamatan ?? '-' }}</span>
                        </div>
                        <div>
                            <span style="color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Desa</span>
                            <span style="color: var(--primary-dark); font-size: 1rem; font-weight: 600; display: block;">{{ $member->desa ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACTIVITY LOG -->
            <div class="table-container member-card">
                <div class="table-header">
                    <h2 class="table-title">Riwayat Aktivitas</h2>
                </div>
                <div style="padding: 25px;">
                    @php
                        $registrations = $member->agendaRegistrations()->with('agenda')->latest()->take(5)->get();
                    @endphp
                    
                    @if($registrations->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            @foreach($registrations as $registration)
                            <div style="display: flex; align-items: start; gap: 15px; padding: 15px; background: #fafafa; border-radius: 8px; border-left: 3px solid var(--accent-gold);">
                                <div style="flex-shrink: 0; width: 40px; height: 40px; background: var(--accent-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--primary-dark)" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div style="flex: 1;">
                                    <h4 style="color: var(--primary-dark); font-size: 0.95rem; font-weight: 600; margin-bottom: 4px;">{{ $registration->agenda->title }}</h4>
                                    <p style="color: #888; font-size: 0.8rem; margin-bottom: 6px;">Mendaftar pada {{ $registration->created_at->format('d M Y, H:i') }}</p>
                                    @if($registration->status == 'confirmed')
                                        <span class="status-badge status-active" style="padding: 3px 10px; font-size: 0.7rem;">Terkonfirmasi</span>
                                    @elseif($registration->status == 'cancelled')
                                        <span class="status-badge" style="padding: 3px 10px; font-size: 0.7rem; background: rgba(255, 107, 107, 0.1); color: #ff6b6b;">Dibatalkan</span>
                                    @else
                                        <span class="status-badge status-pending" style="padding: 3px 10px; font-size: 0.7rem;">Menunggu</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px 20px; color: #999;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" style="margin: 0 auto 15px; opacity: 0.3;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p style="font-size: 0.9rem;">Belum ada aktivitas pendaftaran agenda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- DANGER ZONE -->
    <div class="table-container" style="margin-top: 30px; border: 2px solid #ff6b6b;">
        <div class="table-header" style="background: #fff5f5;">
            <h2 class="table-title" style="color: #ff6b6b;">Zona Berbahaya</h2>
        </div>
        <div style="padding: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <h4 style="color: var(--primary-dark); font-size: 1rem; font-weight: 600; margin-bottom: 5px;">Hapus Anggota</h4>
                <p style="color: #888; font-size: 0.85rem;">Tindakan ini tidak dapat dibatalkan. Data anggota akan dihapus permanen dari sistem.</p>
            </div>
            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini? Tindakan ini tidak dapat dibatalkan!');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: #ff6b6b; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                    Hapus Anggota
                </button>
            </form>
        </div>
    </div>

</div>

<style>
/* Mobile responsive styles moved to admin.css for better control */
.btn-outline {
  background: white;
  color: var(--primary-dark);
  border: 1px solid var(--primary-dark);
  cursor: pointer;
  transition: all 0.3s;
}

.btn-outline:hover {
  background: var(--primary-dark);
  color: var(--accent-gold);
}
</style>
@endsection
