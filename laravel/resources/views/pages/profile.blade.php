@extends('layouts.app')

@section('title', 'Identitas Digital Krama - Dalem Tarukan')

@section('content')
<!-- HERO SECTION -->
<section style="background: linear-gradient(rgba(10, 31, 28, 0.9), rgba(10, 31, 28, 0.9)), url('{{ asset('assets/heritage_hero-opt.webp') }}'); background-size: cover; background-position: center; padding: 80px 0 50px; text-align: center; color: white;">
    <div style="max-width: 1100px; margin: 0 auto; padding: 0 20px; text-align: center;" data-aos="fade-up">
        <h1 style="font-family: 'Cinzel', serif; font-size: clamp(1.8rem, 5vw, 2.5rem); margin-bottom: 10px;">Identitas Digital Krama</h1>
        <p style="font-size: clamp(0.95rem, 2vw, 1.1rem); opacity: 0.8; max-width: 600px; margin: 0 auto;">Informasi resmi keanggotaan Anda dalam Para Gotra Santana Dalem Tarukan.</p>
    </div>
</section>

<section style="padding: 60px 0; background-color: #f9f9f9; min-height: 60vh;">
    <div style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        @if($member->member_status == 'pending' && $member->role !== 'admin')
            <div style="max-width: 800px; margin: 0 auto 40px; background: #fff3cd; border: 1px solid #ffeeba; color: #856404; padding: 20px; border-radius: 12px; display: flex; align-items: center; gap: 15px;" data-aos="fade-up">
                <div style="font-size: 2rem;">⏳</div>
                <div>
                    <h4 style="margin: 0 0 5px; font-weight: 700;">Pendaftaran Sedang Ditinjau</h4>
                    <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">Identitas digital lengkap dan nomor register akan muncul setelah Admin menyetujui pendaftaran Anda. Mohon tunggu proses verifikasi.</p>
                </div>
            </div>
        @endif

        <div class="profile-grid">
            
            <!-- THE CARD -->
            <div data-aos="fade-right">
                <div id="id-card">
                    <!-- Decorative Pattern -->
                    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(212, 175, 55, 0.05); border-radius: 50%;"></div>
                    
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: flex-start; position: relative; z-index: 2;">
                        <img src="{{ asset('assets/Logo.png') }}" alt="Logo" class="card-logo" style="height: 40px;">
                        <div style="text-align: right;">
                            <div class="card-title" style="color: var(--accent-gold); font-family: 'Cinzel', serif; font-size: 1.1rem; font-weight: 700; line-height: 1;">PGSDT</div>
                            <div class="card-subtitle" style="color: rgba(255,255,255,0.4); font-size: 0.6rem; letter-spacing: 2px;">DIGITAL CARD</div>
                        </div>
                    </div>

                    <div class="card-body" style="display: flex; gap: 20px; align-items: center; position: relative; z-index: 2;">
                        <div class="card-photo" style="width: 85px; height: 110px; background: rgba(255,255,255,0.05); border: 1px solid var(--accent-gold); border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                            @if($member->image_path)
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span style="font-size: 2.5rem; color: var(--accent-gold); font-family: 'Cinzel', serif;">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div style="flex: 1; overflow: hidden;">
                            <div class="card-label" style="color: rgba(255,255,255,0.5); font-size: 0.65rem; margin-bottom: 2px; text-transform: uppercase;">Nama Lengkap</div>
                            <div class="card-name" style="color: white; font-family: 'Cinzel', serif; font-size: 1.15rem; font-weight: 700; margin-bottom: 12px; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $member->name }}</div>
                            
                            <div class="card-label" style="color: rgba(255,255,255,0.5); font-size: 0.65rem; margin-bottom: 2px; text-transform: uppercase;">Nomor Register</div>
                            <div class="card-register" style="color: var(--accent-gold); font-family: monospace; font-size: 0.95rem; font-weight: 700;">{{ $member->register_number ?? 'VERIFIKASI...' }}</div>
                        </div>
                    </div>

                    <div class="card-footer" style="display: flex; justify-content: space-between; position: relative; z-index: 2; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.1);">
                        <div>
                            <div class="card-label" style="color: rgba(255,255,255,0.4); font-size: 0.6rem; text-transform: uppercase;">Kabupaten</div>
                            <div class="card-value" style="color: white; font-size: 0.8rem; font-weight: 600;">{{ $member->kabupaten ?? '-' }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div class="card-label" style="color: rgba(255,255,255,0.4); font-size: 0.6rem; text-transform: uppercase;">Status</div>
                            @php
                                $statusColor = match(true) {
                                    $member->role === 'admin'              => '#3498db',
                                    $member->member_status === 'active'    => '#2ecc71',
                                    $member->member_status === 'rejected'  => '#e74c3c',
                                    default                                => '#f1c40f',
                                };
                                $statusLabel = match(true) {
                                    $member->role === 'admin'              => 'ADMIN',
                                    $member->member_status === 'active'    => 'AKTIF',
                                    $member->member_status === 'rejected'  => 'DITOLAK',
                                    default                                => 'PROSES',
                                };
                            @endphp
                            <div class="card-value" style="color: {{ $statusColor }}; font-size: 0.75rem; font-weight: 800;">
                                {{ $statusLabel }}
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 30px; text-align: center; display: flex; justify-content: center; gap: 15px;">
                    <a href="{{ route('profile.edit') }}" class="btn-profile-action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        EDIT PROFIL
                    </a>
                    <button onclick="window.print()" class="btn-profile-action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        CETAK KARTU
                    </button>
                </div>
            </div>

            <!-- PERSONAL DATA -->
            <div data-aos="fade-left" class="personal-data-card">
                <h3 style="font-family: 'Cinzel', serif; color: var(--primary-dark); margin-bottom: 30px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">Data Personal</h3>
                
                <div class="personal-data-grid">
                    <div class="data-item">
                        <label class="data-label">Nama Lengkap</label>
                        <div class="data-value">{{ $member->name }}</div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Nomor Induk Kependudukan (NIK)</label>
                        <div class="data-value data-value-mono">{{ $member->nik }}</div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Nomor Register</label>
                        <div class="data-value data-value-mono" style="color: var(--accent-gold);">{{ $member->register_number ?? 'Menunggu verifikasi admin' }}</div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Alamat Email</label>
                        <div class="data-value text-break">{{ $member->email }}</div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Nomor WhatsApp</label>
                        <div class="data-value">
                            @if($member->phone)
                                <a href="tel:{{ $member->phone }}" style="color: var(--primary-dark); text-decoration: none;">{{ $member->phone }}</a>
                            @else
                                <span style="color: #999; font-style: italic;">Belum dilengkapi</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Kabupaten</label>
                        <div class="data-value">{{ $member->kabupaten ?? '-' }}</div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Kecamatan</label>
                        <div class="data-value">{{ $member->kecamatan ?? '-' }}</div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Desa</label>
                        <div class="data-value">{{ $member->desa ?? '-' }}</div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Status Keanggotaan</label>
                        <div class="data-value">
                            @php
                                $statusBadge = match(true) {
                                    $member->role === 'admin'              => ['color' => '#3498db', 'text' => 'Administrator'],
                                    $member->member_status === 'active'    => ['color' => '#2ecc71', 'text' => 'Aktif'],
                                    $member->member_status === 'rejected'  => ['color' => '#e74c3c', 'text' => 'Ditolak'],
                                    default                                => ['color' => '#f1c40f', 'text' => 'Menunggu Verifikasi'],
                                };
                            @endphp
                            <span style="display: inline-block; padding: 6px 14px; background: {{ $statusBadge['color'] }}; color: white; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">
                                {{ $statusBadge['text'] }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="data-item">
                        <label class="data-label">Tanggal Bergabung</label>
                        <div class="data-value">{{ $member->created_at->format('d F Y') }}</div>
                    </div>
                    
                    @if($member->email_verified_at)
                    <div class="data-item">
                        <label class="data-label">Email Terverifikasi</label>
                        <div class="data-value">
                            <span style="color: #2ecc71;">✓</span> {{ $member->email_verified_at->format('d F Y') }}
                        </div>
                    </div>
                    @endif
                </div>

                <div style="margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 12px; border-left: 4px solid var(--accent-gold);">
                    <p style="margin: 0; font-size: 0.85rem; color: #666; line-height: 1.6;">
                        Kartu ini adalah identitas resmi krama Para Gotra Santana Dalem Tarukan yang tercatat dalam sistem administrasi pusat. Simpan atau cetak kartu ini untuk keperluan paruman dan kegiatan adat lainnya.
                    </p>
                </div>
                
                <div style="margin-top: 30px; display: flex; justify-content: center;">
                    <a href="{{ route('profile.edit') }}" class="btn-profile-action">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        EDIT DATA PERSONAL
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .btn-profile-action {
        display: inline-flex;
        width: auto;
        background: white;
        color: var(--primary-dark);
        border: 2px solid var(--primary-dark);
        padding: 12px 25px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.9rem;
        font-family: 'Cinzel', serif;
        gap: 8px;
        align-items: center;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-profile-action:hover {
        background: white;
        border-color: var(--accent-gold);
        color: var(--accent-gold);
    }

    @media print {
        body {
            visibility: hidden;
            background: white !important;
        }
        #id-card {
            visibility: visible;
            position: absolute;
            left: 0;
            top: 0;
            width: 500px !important;
            height: 316px !important; /* Forces the 1.58 aspect ratio in print */
            margin: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            page-break-inside: avoid;
        }
        #id-card * {
            visibility: visible;
        }
        @page {
            margin: 1cm;
        }
    }
</style>
@endsection
