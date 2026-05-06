@extends('layouts.admin')

@section('title', 'Verifikasi Anggota - Admin Dalem Tarukan')

@section('content')
<div class="table-container member-edit-page" style="padding: 30px;">
  <h2 style="margin-bottom: 20px;">Kelola & Verifikasi Anggota</h2>
  
  @if ($errors->any())
      <div style="background-color: #ffeaea; color: #d93025; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
          <ul style="margin: 0; padding-left: 20px;">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

  <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      
      <div style="display: grid; grid-template-columns: 200px 1fr; gap: 30px; margin-bottom: 30px; align-items: start;">
          <!-- PHOTO UPLOAD -->
          <div>
              <label style="display: block; font-weight: 600; margin-bottom: 10px;">Foto Profil</label>
              <div style="width: 180px; height: 220px; background: #f0f0f0; border-radius: 8px; border: 2px dashed #ddd; overflow: hidden; position: relative; display: flex; align-items: center; justify-content: center;">
                  @if($member->image_path)
                      <img src="{{ asset('storage/' . $member->image_path) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                  @else
                      <div style="text-align: center; color: #aaa;">
                          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-bottom: 10px;">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                          </svg>
                          <div style="font-size: 0.75rem;">Belum ada foto</div>
                      </div>
                  @endif
              </div>
              <input type="file" name="image" style="margin-top: 15px; font-size: 0.8rem; width: 100%;">
          </div>

          <!-- FORM FIELDS -->
          <div>
              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">Nomor Register</label>
                  <input type="text" value="{{ $member->register_number }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; background: #f9f9f9;" disabled>
              </div>

              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">Email Pendaftar</label>
                  <input type="email" value="{{ $member->email }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; background: #f9f9f9;" disabled>
              </div>

              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">Nama Lengkap KTP</label>
                  <input type="text" name="name" value="{{ old('name', $member->name) }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required>
              </div>

              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">NIK</label>
                  <input type="text" name="nik" value="{{ old('nik', $member->nik) }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required>
              </div>

              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">Nomor WhatsApp</label>
                  <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
              </div>

              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">Wilayah / Kabupaten Domisili</label>
                  @php
                  $kabupatenList = [
                      'Jembrana', 'Tabanan', 'Badung', 'Gianyar',
                      'Klungkung', 'Bangli', 'Karangasem', 'Buleleng', 'Denpasar',
                  ];
                  $currentKabupaten = old('kabupaten', $member->kabupaten);
                  @endphp
                  <select name="kabupaten" id="kabupaten" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required>
                      <option value="">Pilih Kabupaten/Kota</option>
                      @foreach($kabupatenList as $kab)
                          <option value="{{ $kab }}" {{ $currentKabupaten == $kab ? 'selected' : '' }}>{{ $kab }}</option>
                      @endforeach
                      {{-- Tampilkan juga jika nilai tidak ada di list (misal format lama) --}}
                      @if($currentKabupaten && !in_array($currentKabupaten, $kabupatenList))
                          <option value="{{ $currentKabupaten }}" selected>{{ $currentKabupaten }}</option>
                      @endif
                  </select>
              </div>

              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">Kecamatan</label>
                  <select name="kecamatan" id="kecamatan" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required disabled>
                      <option value="">Pilih Kabupaten dulu</option>
                  </select>
              </div>

              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">Desa/Kelurahan</label>
                  <select name="desa" id="desa" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required disabled>
                      <option value="">Pilih Kecamatan dulu</option>
                  </select>
              </div>

              <div style="margin-bottom: 20px;">
                  <label style="display: block; font-weight: 600; margin-bottom: 8px;">Status Verifikasi</label>
                  <select name="member_status" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px; font-weight: bold; color: var(--primary-dark);">
                      <option value="pending" {{ $member->member_status == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                      <option value="active" {{ $member->member_status == 'active' ? 'selected' : '' }}>Aktif (Disetujui)</option>
                      <option value="rejected" {{ $member->member_status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                  </select>
              </div>
          </div>
      </div>

      <div style="display: flex; gap: 10px; margin-top: 30px; justify-content: flex-end; border-top: 1px solid #eee; padding-top: 20px;">
          <a href="{{ route('admin.members.index') }}" style="padding: 10px 25px; background: #eee; color: #333; text-decoration: none; border-radius: 4px; font-weight: 600;">Kembali</a>
          <button type="submit" class="btn-primary" style="padding: 10px 30px;">SIMPAN PERUBAHAN</button>
      </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
(function () {
    const kabupatenSelect = document.getElementById('kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');
    const desaSelect      = document.getElementById('desa');

    const savedKabupaten = @json(old('kabupaten', $member->kabupaten));
    const savedKecamatan = @json(old('kecamatan', $member->kecamatan));
    const savedDesa      = @json(old('desa', $member->desa));

    // ── Helpers ──────────────────────────────────────────────────────────────
    function setLoading(select, msg) {
        select.innerHTML = '<option value="">' + msg + '</option>';
        select.disabled = true;
    }

    function buildOptions(select, items, labelKey, valueKey, selectedValue) {
        select.innerHTML = '<option value="">-- Pilih --</option>';
        items.forEach(function(item) {
            const opt = document.createElement('option');
            opt.value     = item[valueKey];
            opt.text      = item[labelKey];
            opt.dataset.id = item.id;
            if (item[valueKey] === selectedValue) opt.selected = true;
            select.appendChild(opt);
        });
        select.disabled = false;
    }

    // ── Load Kabupaten (dari file lokal) ─────────────────────────────────────
    fetch('/api/wilayah/regencies')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            buildOptions(kabupatenSelect, data, 'name', 'name', savedKabupaten);

            // Auto-load kecamatan jika ada nilai tersimpan
            if (savedKabupaten) {
                const sel = Array.from(kabupatenSelect.options).find(function(o) {
                    return o.value === savedKabupaten;
                });
                if (sel && sel.dataset.id) {
                    loadKecamatan(sel.dataset.id, savedKecamatan);
                }
            }
        })
        .catch(function() {
            kabupatenSelect.innerHTML = '<option value="">Gagal memuat data</option>';
        });

    // ── Event: Kabupaten berubah ──────────────────────────────────────────────
    kabupatenSelect.addEventListener('change', function() {
        setLoading(kecamatanSelect, 'Pilih Kecamatan');
        setLoading(desaSelect, 'Pilih Desa');

        const sel = this.options[this.selectedIndex];
        if (sel && sel.dataset.id) {
            loadKecamatan(sel.dataset.id, null);
        }
    });

    // ── Event: Kecamatan berubah ──────────────────────────────────────────────
    kecamatanSelect.addEventListener('change', function() {
        setLoading(desaSelect, 'Memuat desa...');

        const sel = this.options[this.selectedIndex];
        if (sel && sel.dataset.id) {
            loadDesa(sel.dataset.id, null);
        }
    });

    // ── Load Kecamatan ────────────────────────────────────────────────────────
    function loadKecamatan(regencyId, selectedValue) {
        setLoading(kecamatanSelect, 'Memuat kecamatan...');
        setLoading(desaSelect, 'Pilih Desa');

        fetch('/api/wilayah/districts/' + regencyId)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                buildOptions(kecamatanSelect, data, 'name', 'name', selectedValue);

                if (selectedValue) {
                    const sel = Array.from(kecamatanSelect.options).find(function(o) {
                        return o.value === selectedValue;
                    });
                    if (sel && sel.dataset.id) {
                        loadDesa(sel.dataset.id, savedDesa);
                    }
                }
            })
            .catch(function() {
                kecamatanSelect.innerHTML = '<option value="">Gagal memuat</option>';
                kecamatanSelect.disabled = false;
            });
    }

    // ── Load Desa ─────────────────────────────────────────────────────────────
    function loadDesa(districtId, selectedValue) {
        setLoading(desaSelect, 'Memuat desa...');

        fetch('/api/wilayah/villages/' + districtId)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                buildOptions(desaSelect, data, 'name', 'name', selectedValue);
            })
            .catch(function() {
                desaSelect.innerHTML = '<option value="">Gagal memuat</option>';
                desaSelect.disabled = false;
            });
    }
})();
</script>
@endsection
