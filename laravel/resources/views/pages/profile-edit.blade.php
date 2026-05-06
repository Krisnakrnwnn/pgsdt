@extends('layouts.app')

@section('title', 'Edit Profil Krama - Dalem Tarukan')

@section('content')
<section class="profile-edit-hero">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 20px; text-align: center;" data-aos="fade-up">
        <h1 style="font-family: 'Cinzel', serif; font-size: clamp(1.8rem, 5vw, 2.5rem); margin-bottom: 10px;">Lengkapi Data Diri</h1>
        <p style="font-size: clamp(0.95rem, 2vw, 1.1rem); opacity: 0.8; max-width: 600px; margin: 0 auto;">Pastikan data Anda sesuai dengan KTP untuk memudahkan proses administrasi.</p>
    </div>
</section>

<section style="padding: 80px 0; background-color: #f9f9f9; min-height: 60vh;">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        <div class="profile-edit-card">
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="error-alert">
                        <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="profile-edit-grid">
                    <!-- PHOTO SECTION -->
                    <div class="photo-section">
                        <label class="photo-label">Foto Profil</label>
                        <div id="image-preview-container" class="image-preview">
                            @if($member->image_path)
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="Current Photo" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div id="placeholder-icon" class="placeholder-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <div style="font-size: 0.75rem; margin-top: 10px;">Belum ada foto</div>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="image" id="image" style="display: none;" onchange="previewImage(this)">
                        <label for="image" class="photo-upload-btn">GANTI FOTO</label>
                        <p class="photo-hint">Format: JPG, PNG, WebP (Max. 5MB)</p>
                    </div>

                    <!-- DATA FIELDS -->
                    <div class="form-fields">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="name" value="{{ old('name', $member->name) }}" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" name="nik" id="nik-edit"
                                   value="{{ old('nik', $member->nik) }}"
                                   class="form-input form-input-mono"
                                   maxlength="16" pattern="[0-9]{16}" inputmode="numeric" required
                                   oninput="this.value=this.value.replace(/[^0-9]/g,''); validateNIKEdit(this);">
                            <small id="nik-edit-hint" class="form-hint">Masukkan 16 digit angka sesuai KTP</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="form-input" placeholder="Contoh: 08123456789" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kabupaten/Kota Domisili</label>
                            <select name="kabupaten" id="kabupaten" required class="form-select">
                                <option value="">Pilih Kabupaten</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" required disabled class="form-select">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Desa/Kelurahan</label>
                            <select name="desa" id="desa" required disabled class="form-select">
                                <option value="">Pilih Desa</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('profile') }}" class="btn-cancel">BATAL</a>
                            <button type="submit" class="btn-submit">SIMPAN PERUBAHAN</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var container = document.getElementById('image-preview-container');
            container.innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kabupatenSelect = document.getElementById('kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');
    const desaSelect = document.getElementById('desa');

    const oldKabupaten = @json(old('kabupaten', $member->kabupaten));
    const oldKecamatan = @json(old('kecamatan', $member->kecamatan));
    const oldDesa      = @json(old('desa', $member->desa));

    // Gunakan API lokal
    fetch('/api/wilayah/regencies')
        .then(r => r.json())
        .then(regencies => {
            regencies.forEach(regency => {
                let option = document.createElement('option');
                option.value = regency.name;
                option.text = regency.name;
                option.dataset.id = regency.id;
                if (regency.name === oldKabupaten) option.selected = true;
                kabupatenSelect.appendChild(option);
            });
            kabupatenSelect.disabled = false;

            if (oldKabupaten) {
                const sel = Array.from(kabupatenSelect.options).find(o => o.value === oldKabupaten);
                if (sel && sel.dataset.id) fetchKecamatan(sel.dataset.id, oldKecamatan);
            }
        })
        .catch(() => { kabupatenSelect.innerHTML = '<option value="">Gagal memuat</option>'; });

    kabupatenSelect.addEventListener('change', function() {
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
        kecamatanSelect.disabled = true;
        desaSelect.disabled = true;
        const sel = this.options[this.selectedIndex];
        if (sel && sel.dataset.id) fetchKecamatan(sel.dataset.id);
    });

    kecamatanSelect.addEventListener('change', function() {
        desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
        desaSelect.disabled = true;
        const sel = this.options[this.selectedIndex];
        if (sel && sel.dataset.id) fetchDesa(sel.dataset.id);
    });

    function fetchKecamatan(regencyId, selectedValue = null) {
        kecamatanSelect.innerHTML = '<option value="">Memuat...</option>';
        kecamatanSelect.disabled = true;
        fetch('/api/wilayah/districts/' + regencyId)
            .then(r => r.json())
            .then(districts => {
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                districts.forEach(d => {
                    let opt = document.createElement('option');
                    opt.value = d.name; opt.text = d.name; opt.dataset.id = d.id;
                    if (d.name === selectedValue) opt.selected = true;
                    kecamatanSelect.appendChild(opt);
                });
                kecamatanSelect.disabled = false;
                if (selectedValue) {
                    const sel = Array.from(kecamatanSelect.options).find(o => o.value === selectedValue);
                    if (sel && sel.dataset.id) fetchDesa(sel.dataset.id, oldDesa);
                }
            })
            .catch(() => { kecamatanSelect.disabled = false; });
    }

    function fetchDesa(districtId, selectedValue = null) {
        desaSelect.innerHTML = '<option value="">Memuat...</option>';
        desaSelect.disabled = true;
        fetch('/api/wilayah/villages/' + districtId)
            .then(r => r.json())
            .then(villages => {
                desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
                villages.forEach(v => {
                    let opt = document.createElement('option');
                    opt.value = v.name; opt.text = v.name;
                    if (v.name === selectedValue) opt.selected = true;
                    desaSelect.appendChild(opt);
                });
                desaSelect.disabled = false;
            })
            .catch(() => { desaSelect.disabled = false; });
    }
});
</script>

<script>
function validateNIKEdit(input) {
    const hint = document.getElementById('nik-edit-hint');
    const len  = input.value.length;
    if (len === 0) {
        hint.style.color = '#aaa';
        hint.textContent = 'Masukkan 16 digit angka sesuai KTP';
        input.style.borderColor = '#ddd';
    } else if (len < 16) {
        hint.style.color = '#e67e22';
        hint.textContent = len + '/16 digit';
        input.style.borderColor = '#e67e22';
    } else {
        hint.style.color = '#27ae60';
        hint.textContent = '✓ NIK valid';
        input.style.borderColor = '#27ae60';
    }
}
// Jalankan validasi saat halaman load jika sudah ada nilai
document.addEventListener('DOMContentLoaded', function() {
    const nikInput = document.getElementById('nik-edit');
    if (nikInput && nikInput.value) validateNIKEdit(nikInput);
});
</script>
