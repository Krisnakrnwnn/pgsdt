@extends('layouts.app')

@section('title', 'Registrasi Anggota - Dalem Tarukan')
@section('meta_description', 'Daftarkan diri sebagai krama Para Gotra Santana Dalem Tarukan. Dapatkan kartu anggota digital dan akses ke seluruh layanan keluarga besar.')

@section('content')
  <section class="hero" style="background-image: url('{{ asset('assets/heritage_hero-opt.webp') }}'); border-radius: 0;">
    <div class="hero-content hero-box-mobile" data-aos="fade-up">
        <h1 style="font-family: 'Cinzel', serif; font-size: clamp(1.8rem, 6vw, 3rem); margin-bottom: 10px;">Pendaftaran Anggota</h1>
        <p style="font-size: clamp(0.9rem, 2vw, 1.2rem); opacity: 0.9; text-transform: uppercase; letter-spacing: clamp(1px, 0.5vw, 2px);">Bergabung Menjadi Krama Para Gotra Santana Dalem Tarukan</p>
    </div>
  </section>

  <section style="padding: 60px 0; background: var(--section-bg); min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div style="max-width: 500px; margin: 0 auto; padding: 0 15px; width: 100%;">
        <div class="member-form-container" data-aos="fade-up" style="background: white; border: 1px solid rgba(212,175,55,0.2); padding: clamp(30px, 8vw, 50px); border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.08); text-align: center;">
          <img src="{{ asset('assets/Logo.png') }}" alt="Dalem Tarukan" style="height: 70px; margin: 0 auto 25px; display: block;">
          <h2 style="font-family: 'Cinzel', serif; color: var(--primary-dark); margin-bottom: 15px; font-size: clamp(1.5rem, 6vw, 2.2rem); line-height: 1.2;">Gabung Jadi Krama</h2>
          <p style="color: #666; font-size: clamp(0.95rem, 3vw, 1.1rem); line-height: 1.6; margin-bottom: 35px; max-width: 90%; margin-left: auto; margin-right: auto;">
            Pendaftaran anggota baru PGSDT lebih mudah dan aman menggunakan akun <strong style="color: var(--primary-dark);">Google / Gmail</strong>.
          </p>

          <a href="{{ route('auth.google') }}" style="width: 100%; padding: 18px 15px; border-radius: 12px; border: none; background: var(--primary-dark); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: clamp(0.9rem, 4vw, 1.1rem); font-weight: 800; font-family: 'Cinzel', serif; transition: all 0.3s; box-sizing: border-box; text-transform: uppercase; letter-spacing: 1.5px; box-shadow: 0 10px 20px rgba(10,31,28,0.2); white-space: nowrap;" 
             onmouseover="this.style.background='var(--accent-gold)'; this.style.color='var(--primary-dark)'; this.style.transform='translateY(-2px)'" 
             onmouseout="this.style.background='var(--primary-dark)'; this.style.color='white'; this.style.transform='translateY(0)'">
              <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" style="width: 22px; height: 22px; margin-right: 12px; filter: brightness(0) invert(1);" id="google-icon">
              <span>Daftar Sekarang</span>
          </a>

          <div style="margin-top: 40px; padding-top: 25px; border-top: 1px solid #eee;">
            <p style="color: #888; font-size: 0.9rem; margin-bottom: 8px;">Sudah pernah mendaftar?</p>
            <a href="{{ url('/login') }}" style="color: var(--accent-gold); font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.9rem; border-bottom: 2px solid transparent; transition: all 0.3s;" onmouseover="this.style.borderBottomColor='var(--accent-gold)'" onmouseout="this.style.borderBottomColor='transparent'">Masuk di sini</a>
          </div>
        </div>
    </div>
  </section>

  <script>
    const btn = document.querySelector('a[href="{{ route("auth.google") }}"]');
    const icon = document.getElementById('google-icon');
    if (btn && icon) {
        btn.addEventListener('mouseover', () => icon.style.filter = 'none');
        btn.addEventListener('mouseout', () => icon.style.filter = 'brightness(0) invert(1)');
    }
  </script>
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
