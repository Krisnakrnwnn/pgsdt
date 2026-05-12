@extends('layouts.app')

@section('title', 'Registrasi Anggota - Dalem Tarukan')
@section('meta_description', 'Daftarkan diri sebagai krama Para Gotra Santana Dalem Tarukan. Dapatkan kartu anggota digital dan akses ke seluruh layanan keluarga besar.')

@section('content')
<div style="background: var(--primary-dark); min-height: 100vh;">

  <!-- HERO HEADER -->
  <div style="position: relative; min-height: 280px; background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; padding-top: 85px;">
    <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(10,31,28,0.75), rgba(10,31,28,0.95)); z-index: 1;"></div>
    <div class="hero-content hero-box-mobile" data-aos="fade-up" style="position: relative; z-index: 2; text-align: center;">
        <h1 style="font-family: 'Cinzel', serif; font-size: clamp(1.8rem, 6vw, 3rem); margin-bottom: 10px; color: white;">Pendaftaran Anggota</h1>
        <p style="font-size: clamp(0.9rem, 2vw, 1.1rem); opacity: 0.85; text-transform: uppercase; letter-spacing: clamp(1px, 0.5vw, 2px); color: rgba(255,255,255,0.8);">Bergabung Menjadi Krama Para Gotra Santana Dalem Tarukan</p>
    </div>
  </div>

  <section style="padding: 60px 0 80px;">
    <div style="max-width: 700px; margin: 0 auto; padding: 0 20px;">
        <!-- Registration Form -->
        <div class="member-form-container" data-aos="fade-up" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(212,175,55,0.2); padding: 40px; border-radius: 4px;">
          <h3 style="font-family: 'Cinzel', serif; color: white; margin-bottom: 35px; font-size: clamp(1.3rem, 4vw, 1.8rem); text-align: center; border-bottom: 1px solid rgba(212,175,55,0.2); padding-bottom: 20px;">Formulir Registrasi</h3>
          
          @if ($errors->any())
              <div style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); color: #ff8a80; padding: 15px; border-radius: 0; margin-bottom: 25px; font-size: 0.9rem;">
                  <ul style="margin: 0; padding-left: 20px;">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div style="margin-bottom: 20px;">
              <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Nama Lengkap *</label>
              <input type="text" name="name" value="{{ old('name') }}" required
                     style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s;"
                     placeholder="Nama Lengkap Anda"
                     onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                     onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
            </div>

            <div style="margin-bottom: 20px;">
              <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Email *</label>
              <input type="email" name="email" value="{{ old('email') }}" required
                     style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s;"
                     placeholder="email@contoh.com"
                     onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                     onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
            </div>

            <div class="member-form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
              <div>
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">NIK *</label>
                <input type="text" name="nik" id="nik-input" value="{{ old('nik') }}" required maxlength="16" pattern="[0-9]{16}" inputmode="numeric"
                       style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s;"
                       placeholder="16 digit NIK"
                       oninput="this.value=this.value.replace(/[^0-9]/g,''); validateNIK(this);"
                       onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                <small id="nik-hint" style="display: block; margin-top: 5px; font-size: 0.75rem; color: rgba(255,255,255,0.4);">Masukkan 16 digit angka sesuai KTP</small>
              </div>
              <div>
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">No. Telepon *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                       style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s;"
                       placeholder="08xxxxxxxxxx"
                       onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
              </div>
            </div>

            <div class="member-location-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
              <div>
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Kabupaten/Kota *</label>
                <select name="kabupaten" id="kabupaten" required
                       style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s; appearance: none;">
                    <option value="" style="color: black;">Pilih Kabupaten</option>
                </select>
              </div>
              <div>
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Kecamatan *</label>
                <select name="kecamatan" id="kecamatan" required disabled
                       style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s; appearance: none;">
                    <option value="" style="color: black;">Pilih Kecamatan</option>
                </select>
              </div>
              <div>
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Desa/Kelurahan *</label>
                <select name="desa" id="desa" required disabled
                       style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s; appearance: none;">
                    <option value="" style="color: black;">Pilih Desa</option>
                </select>
              </div>
            </div>

            <div style="margin-bottom: 20px;">
              <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Kata Sandi *</label>
              <input type="password" name="password" required
                     style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s;"
                     placeholder="Minimal 8 karakter"
                     onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                     onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
            </div>

            <div style="margin-bottom: 35px;">
              <label style="display: block; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;">Konfirmasi Kata Sandi *</label>
              <input type="password" name="password_confirmation" required
                     style="width: 100%; padding: 14px 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0; color: white; font-family: 'Cinzel', serif; font-size: 0.95rem; outline: none; transition: border-color 0.3s;"
                     placeholder="Ulangi kata sandi"
                     onfocus="this.style.borderColor='rgba(212,175,55,0.5)'"
                     onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 18px; border-radius: 0; border: none; cursor: pointer; font-size: 1rem; letter-spacing: 3px;">
                DAFTAR SEKARANG
            </button>

            <div style="margin: 25px 0; display: flex; align-items: center; justify-content: center;">
                <div style="flex: 1; height: 1px; background: rgba(255,255,255,0.1);"></div>
                <span style="margin: 0 15px; color: rgba(255,255,255,0.3); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px;">Atau</span>
                <div style="flex: 1; height: 1px; background: rgba(255,255,255,0.1);"></div>
            </div>

            <a href="{{ route('auth.google') }}" style="width: 100%; padding: 16px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.9rem; font-family: 'Inter', sans-serif; transition: all 0.3s; box-sizing: border-box;" 
               onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(212,175,55,0.5)'" 
               onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" style="width: 18px; margin-right: 12px;">
                DAFTAR DENGAN GOOGLE
            </a>
          </form>

          <div style="text-align: center; margin-top: 30px; font-size: 0.9rem; color: #888;">
              Sudah memiliki akun? <a href="{{ url('/login') }}" style="color: var(--accent-gold); font-weight: 700; text-decoration: none; border-bottom: 1px solid var(--accent-gold); text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem;">Masuk di sini</a>
          </div>
        </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kabupatenSelect = document.getElementById('kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');
    const desaSelect = document.getElementById('desa');

    const oldKabupaten = "{{ old('kabupaten') }}";
    const oldKecamatan = "{{ old('kecamatan') }}";
    const oldDesa = "{{ old('desa') }}";

    // Gunakan API lokal agar tidak bergantung server eksternal
    fetch('/api/wilayah/regencies')
        .then(response => response.json())
        .then(regencies => {
            regencies.forEach(regency => {
                let option = document.createElement('option');
                option.value = regency.name;
                option.text = regency.name;
                option.dataset.id = regency.id;
                option.style.color = 'black';
                if (regency.name === oldKabupaten) option.selected = true;
                kabupatenSelect.appendChild(option);
            });

            if (oldKabupaten) {
                const selectedOption = Array.from(kabupatenSelect.options).find(o => o.value === oldKabupaten);
                if (selectedOption && selectedOption.dataset.id) {
                    fetchKecamatan(selectedOption.dataset.id, oldKecamatan);
                }
            }
        })
        .catch(error => console.error('Error fetching regencies:', error));

    kabupatenSelect.addEventListener('change', function() {
        kecamatanSelect.innerHTML = '<option value="" style="color: black;">Pilih Kecamatan</option>';
        desaSelect.innerHTML = '<option value="" style="color: black;">Pilih Desa</option>';
        kecamatanSelect.disabled = true;
        desaSelect.disabled = true;

        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.value !== "") {
            fetchKecamatan(selectedOption.dataset.id);
        }
    });

    kecamatanSelect.addEventListener('change', function() {
        desaSelect.innerHTML = '<option value="" style="color: black;">Pilih Desa</option>';
        desaSelect.disabled = true;

        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.value !== "") {
            fetchDesa(selectedOption.dataset.id);
        }
    });

    function fetchKecamatan(regencyId, selectedValue = null) {
        kecamatanSelect.disabled = false;
        fetch('/api/wilayah/districts/' + regencyId)
            .then(response => response.json())
            .then(districts => {
                kecamatanSelect.innerHTML = '<option value="" style="color: black;">Pilih Kecamatan</option>';
                districts.forEach(district => {
                    let option = document.createElement('option');
                    option.value = district.name;
                    option.text = district.name;
                    option.dataset.id = district.id;
                    option.style.color = 'black';
                    if (district.name === selectedValue) option.selected = true;
                    kecamatanSelect.appendChild(option);
                });

                if (selectedValue) {
                    const selOpt = Array.from(kecamatanSelect.options).find(o => o.value === selectedValue);
                    if (selOpt && selOpt.dataset.id) {
                        fetchDesa(selOpt.dataset.id, oldDesa);
                    }
                }
            })
            .catch(error => console.error('Error fetching districts:', error));
    }

    function fetchDesa(districtId, selectedValue = null) {
        desaSelect.disabled = false;
        fetch('/api/wilayah/villages/' + districtId)
            .then(response => response.json())
            .then(villages => {
                desaSelect.innerHTML = '<option value="" style="color: black;">Pilih Desa</option>';
                villages.forEach(village => {
                    let option = document.createElement('option');
                    option.value = village.name;
                    option.text = village.name;
                    option.dataset.id = village.id;
                    option.style.color = 'black';
                    if (village.name === selectedValue) option.selected = true;
                    desaSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching villages:', error));
    }
});
</script>
@endsection
