@extends('layouts.app')

@section('title', 'Pendaftaran Acara - ' . $agenda->title)

@section('content')
<section class="registration-page" style="padding: 120px 0 80px; background: var(--section-bg);">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">

        {{-- Tombol kembali --}}
        <a href="{{ route('events.show', $agenda->slug) }}"
           style="display: inline-flex; align-items: center; gap: 8px; color: var(--accent-gold); text-decoration: none; font-weight: 600; font-size: 0.9rem; margin-bottom: 30px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            KEMBALI KE DETAIL AGENDA
        </a>
        <div data-aos="fade-up" style="background: var(--primary-dark); border-radius: 0px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.3); border: 1px solid rgba(212, 175, 55, 0.2);">
            <!-- Header -->
            <div style="background: linear-gradient(to bottom, rgba(212, 175, 55, 0.1), transparent); padding: 50px 40px; text-align: center; border-bottom: 1px solid rgba(212, 175, 55, 0.1);">
                <span style="color: var(--accent-gold); letter-spacing: 3px; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; display: block; margin-bottom: 15px;">KONFIRMASI KEHADIRAN</span>
                <h2 style="font-family: 'Cinzel', serif; margin: 0; font-size: 2.2rem; color: white; line-height: 1.2;">{{ $agenda->title }}</h2>
            </div>

            <!-- Body -->
            <div style="padding: 40px;">
                <!-- Event Brief Info -->
                <div style="background: rgba(255,255,255,0.03); padding: 25px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 40px; display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; font-size: 1rem; color: var(--accent-gold-light); font-weight: 600;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($agenda->event_date)->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $agenda->location ?? 'Lokasi segera diumumkan' }}</span>
                    </div>
                </div>

                <form action="{{ route('events.register.store', $agenda->slug) }}" method="POST">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <div>
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #aaa; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->name }}" disabled style="width: 100%; padding: 14px; border: 1px solid rgba(255,255,255,0.1); border-radius: 0px; background: rgba(255,255,255,0.05); color: #fff; cursor: not-allowed; font-family: 'Cinzel', serif;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 10px; font-weight: 600; color: #aaa; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">WhatsApp / Telepon</label>
                            <input type="text" value="{{ Auth::user()->phone ?? '-' }}" disabled style="width: 100%; padding: 14px; border: 1px solid rgba(255,255,255,0.1); border-radius: 0px; background: rgba(255,255,255,0.05); color: {{ Auth::user()->phone ? '#fff' : '#888' }}; cursor: not-allowed;">
                            @if(!Auth::user()->phone)
                            <small style="color: rgba(212,175,55,0.7); font-size: 0.75rem; display: block; margin-top: 5px;">
                                <a href="{{ route('profile.edit') }}" style="color: var(--accent-gold); text-decoration: underline;">Lengkapi nomor telepon</a> di profil Anda.
                            </small>
                            @endif
                        </div>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <label for="information_source" style="display: block; margin-bottom: 10px; font-weight: 600; color: var(--accent-gold); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Sumber Informasi Acara <span style="color: var(--accent-gold);">*</span></label>
                        <select id="information_source" name="information_source" required onchange="toggleOtherSource(this.value)" style="width: 100%; padding: 16px; border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 0px; font-family: inherit; background: rgba(255,255,255,0.05); color: white; cursor: pointer;">
                            <option value="" disabled selected style="background: var(--primary-dark);">-- Pilih Sumber Informasi --</option>
                            <option value="Website Resmi" style="background: var(--primary-dark);">Website Resmi Dalem Tarukan</option>
                            <option value="Grup WhatsApp" style="background: var(--primary-dark);">Grup WhatsApp Keluarga Besar</option>
                            <option value="Media Sosial" style="background: var(--primary-dark);">Media Sosial (Facebook/Instagram)</option>
                            <option value="Pengurus DPC/DPP" style="background: var(--primary-dark);">Pengurus DPC / DPP</option>
                            <option value="Keluarga/Saudara" style="background: var(--primary-dark);">Keluarga / Saudara</option>
                            <option value="Lainnya" style="background: var(--primary-dark);">Lainnya</option>
                        </select>
                    </div>

                    <div id="other_source_container" style="display: none; margin-bottom: 30px;">
                        <label for="other_source" style="display: block; margin-bottom: 10px; font-weight: 600; color: var(--accent-gold); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Sebutkan Sumber Lainnya <span style="color: var(--accent-gold);">*</span></label>
                        <input type="text" id="other_source" name="other_source" placeholder="Misal: Surat Undangan Fisik" style="width: 100%; padding: 16px; border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 0px; background: rgba(255,255,255,0.05); color: white;">
                    </div>

                    <script>
                        function toggleOtherSource(value) {
                            const container = document.getElementById('other_source_container');
                            const input = document.getElementById('other_source');
                            if (value === 'Lainnya') {
                                container.style.display = 'block';
                                input.setAttribute('required', 'required');
                            } else {
                                container.style.display = 'none';
                                input.removeAttribute('required');
                            }
                        }
                    </script>

                    <div style="background: rgba(212, 175, 55, 0.05); padding: 25px; border-radius: 0px; border-left: 4px solid var(--accent-gold); margin-bottom: 40px;">
                        <p style="font-size: 0.9rem; margin-bottom: 0; color: var(--accent-gold-light); line-height: 1.6;">
                            "Dengan mendaftarkan diri, titiang menyatakan bersedia hadir dalam acara ini guna mempererat persaudaraan Para Gotra Santana Dalem Tarukan."
                        </p>
                    </div>

                    <div style="display: flex; gap: 20px;">
                        <a href="{{ route('events.show', $agenda->slug) }}" style="flex: 1; padding: 18px; border: 1px solid rgba(255,255,255,0.1); border-radius: 0px; text-align: center; text-decoration: none; color: #fff; font-weight: 700; font-size: 0.8rem; letter-spacing: 2px;">BATAL</a>
                        <button type="submit" class="btn-primary" style="flex: 2; border: none; cursor: pointer; border-radius: 0px; padding: 18px; font-weight: 700; letter-spacing: 2px;">KONFIRMASI KEHADIRAN</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
