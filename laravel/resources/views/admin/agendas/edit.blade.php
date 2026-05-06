@extends('layouts.admin')

@section('title', 'Edit Agenda - Admin Dalem Tarukan')

@section('content')
<div class="agenda-edit-page">
  <div class="agenda-edit-inner">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="margin: 0; color: var(--primary-dark); font-family: 'Cinzel', serif; font-size: 1.8rem;">Edit Agenda Acara</h2>
            <p style="color: var(--text-dim); margin-top: 5px;">Perbarui detail dan informasi kegiatan bersama.</p>
        </div>
        <a href="{{ route('admin.agendas.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-dark); text-decoration: none; font-weight: 600; font-size: 0.9rem; padding: 10px 20px; border: 1px solid #ddd; background: white;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            KEMBALI
        </a>
    </div>

    @if ($errors->any())
        <div style="padding: 15px; background: #fff5f5; color: #c53030; border-left: 4px solid #c53030; margin-bottom: 30px;">
            <ul style="margin: 0; padding-left: 20px; font-weight: 500;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            <!-- LEFT COLUMN: Main Info -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <!-- SECTION: Informasi Dasar -->
                <div style="background: white; padding: 30px; border: 1px solid #eee; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                    <h3 style="margin-bottom: 20px; color: var(--primary-dark); font-family: 'Cinzel', serif; font-size: 1.2rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">Informasi Dasar</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="title" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark);">Judul Agenda <span style="color: #e53e3e;">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $agenda->title) }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 0px; font-family: inherit; font-size: 1.1rem;" placeholder="Contoh: Musyawarah Agung Dalem Tarukan">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="description" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark);">Detail & Deskripsi <span style="color: #e53e3e;">*</span></label>
                        <textarea id="description" name="description" rows="8" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 0px; font-family: inherit; resize: vertical;" placeholder="Jelaskan detail kegiatan secara lengkap...">{{ old('description', $agenda->description) }}</textarea>
                    </div>
                </div>

                <!-- SECTION: Jadwal Acara (Rundown) -->
                <div style="background: white; padding: 30px; border: 1px solid #eee; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <h3 style="margin: 0; color: var(--primary-dark); font-family: 'Cinzel', serif; font-size: 1.2rem;">Jadwal Acara / Rundown</h3>
                        <div style="display: flex; gap: 10px;">
                            <button type="button" onclick="toggleBulkImport()" style="padding: 6px 12px; background: #666; color: white; border: none; font-size: 0.8rem; font-weight: 600; cursor: pointer;">PASTE JADWAL</button>
                            <button type="button" onclick="addItineraryRow()" style="padding: 6px 12px; background: var(--accent-gold); color: white; border: none; font-size: 0.8rem; font-weight: 600; cursor: pointer;">+ BARIS</button>
                        </div>
                    </div>

                    <!-- Bulk Import Area (Hidden by default) -->
                    <div id="bulk-import-area" style="display: none; margin-bottom: 20px; background: #f8f9fa; padding: 20px; border: 1px dashed #ccc;">
                        <label style="display: block; margin-bottom: 10px; font-weight: 600;">Tempel Jadwal dari Excel/WhatsApp:</label>
                        <textarea id="bulk-input" rows="5" placeholder="Contoh:&#10;08.00 - 08.30 Registrasi&#10;08.30 - 09.00 Pembukaan" style="width: 100%; padding: 10px; border: 1px solid #ccc; font-family: monospace;"></textarea>
                        <div style="margin-top: 10px; display: flex; gap: 10px;">
                            <button type="button" onclick="processBulkImport()" style="padding: 5px 15px; background: #28a745; color: white; border: none; cursor: pointer; font-size: 0.85rem;">IMPOR SEKARANG</button>
                            <button type="button" onclick="toggleBulkImport()" style="padding: 5px 15px; background: #999; color: white; border: none; cursor: pointer; font-size: 0.85rem;">BATAL</button>
                        </div>
                    </div>

                    <div style="overflow-x: auto;">
                        <table id="itinerary-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="text-align: left; background: #f4f4f4;">
                                    <th style="padding: 12px; border: 1px solid #ddd; width: 50px; text-align: center;">NO</th>
                                    <th style="padding: 12px; border: 1px solid #ddd; width: 110px;">MULAI</th>
                                    <th style="padding: 12px; border: 1px solid #ddd; width: 110px;">SELESAI</th>
                                    <th style="padding: 12px; border: 1px solid #ddd;">KEGIATAN / ACARA</th>
                                    <th style="padding: 12px; border: 1px solid #ddd; width: 60px; text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody id="itinerary-body">
                                <!-- Rows will be added here by JS -->
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="itinerary" id="itinerary-hidden-input" value="{{ old('itinerary', $agenda->itinerary) }}">
                </div>
            </div>

            <!-- RIGHT COLUMN: Metadata & Settings -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                <!-- SECTION: Status & Kontrol -->
                <div style="background: white; padding: 25px; border: 1px solid #eee; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                    <h3 style="margin-bottom: 20px; color: var(--primary-dark); font-family: 'Cinzel', serif; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">Pengaturan Acara</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="status" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark);">Status Publikasi</label>
                        <select id="status" name="status" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 0px; font-family: inherit; background: white;">
                            <option value="upcoming" {{ old('status', $agenda->status) == 'upcoming' ? 'selected' : '' }}>Mendatang (Upcoming)</option>
                            <option value="completed" {{ old('status', $agenda->status) == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                            <option value="cancelled" {{ old('status', $agenda->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                        </select>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 15px; margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
                        <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: 600; color: var(--text-dark);">
                            <input type="checkbox" id="registration_enabled" name="registration_enabled" value="1" {{ $agenda->registration_enabled ? 'checked' : '' }} onchange="toggleQuota(this.checked)" style="width: 20px; height: 20px;">
                            Aktifkan Pendaftaran
                        </label>
                        
                        <div id="quota-container" style="margin-top: 5px; {{ $agenda->registration_enabled ? '' : 'display: none;' }}">
                            <label for="quota" style="display: block; margin-bottom: 5px; font-size: 0.9rem; font-weight: 600;">Kuota Peserta</label>
                            <input type="number" id="quota" name="quota" value="{{ old('quota', $agenda->quota) }}" min="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 0px;">
                        </div>

                        <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; font-weight: 600; color: var(--accent-gold); margin-top: 10px;">
                            <input type="checkbox" name="is_featured" value="1" {{ $agenda->is_featured ? 'checked' : '' }} style="width: 20px; height: 20px;">
                            ⭐ Jadikan Agenda Utama
                        </label>
                    </div>
                </div>

                <!-- SECTION: Waktu & Lokasi -->
                <div style="background: white; padding: 25px; border: 1px solid #eee; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                    <h3 style="margin-bottom: 20px; color: var(--primary-dark); font-family: 'Cinzel', serif; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">Waktu & Lokasi</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="event_date" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark);">Tanggal & Jam <span style="color: #e53e3e;">*</span></label>
                        <input type="datetime-local" id="event_date" name="event_date" value="{{ old('event_date', date('Y-m-d\TH:i', strtotime($agenda->event_date))) }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 0px; font-family: inherit;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="location" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark);">Nama Lokasi</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $agenda->location) }}" placeholder="Contoh: Pura Dalem Tarukan" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 0px; font-family: inherit;">
                    </div>

                    <div style="margin-bottom: 5px;">
                        <label for="location_map" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark);">Link Google Maps</label>
                        <input type="text" id="location_map" name="location_map" value="{{ old('location_map', $agenda->location_map) }}" placeholder="Tempel link share maps..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 0px; font-family: inherit;">
                        <small style="color: #888; display: block; margin-top: 5px;">Cukup tempel link 'Bagikan' dari Google Maps.</small>
                    </div>
                </div>

                <!-- SECTION: Media -->
                <div style="background: white; padding: 25px; border: 1px solid #eee; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                    <h3 style="margin-bottom: 20px; color: var(--primary-dark); font-family: 'Cinzel', serif; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">Poster / Gambar</h3>
                    
                    @if($agenda->image_path)
                        <div style="margin-bottom: 15px; background: #f4f4f4; padding: 10px; border: 1px solid #ddd; text-align: center;">
                            <img src="{{ asset('storage/' . $agenda->image_path) }}" alt="Preview" style="max-width: 100%; max-height: 200px;">
                            <p style="margin-top: 5px; font-size: 0.8rem; color: #666;">Poster Saat Ini</p>
                        </div>
                    @endif

                    <div style="margin-bottom: 5px;">
                        <label for="image" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-dark);">Ganti Gambar</label>
                        <input type="file" id="image" name="image" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 0px; background: #fafafa;">
                        <small style="color: #888; display: block; margin-top: 5px;">Biarkan kosong jika tidak diubah. Maks: 2MB.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORM ACTIONS -->
        <div style="margin-top: 40px; padding: 30px; background: white; border-top: 3px solid var(--accent-gold); display: flex; justify-content: flex-end; gap: 20px; box-shadow: 0 -10px 30px rgba(0,0,0,0.03);">
            <a href="{{ route('admin.agendas.index') }}" style="padding: 12px 30px; border: 1px solid #ddd; color: var(--text-dark); text-decoration: none; font-weight: 700; font-size: 0.9rem; letter-spacing: 1px;">BATAL</a>
            <button type="submit" style="padding: 12px 40px; background: var(--primary-dark); color: white; border: none; font-weight: 700; font-size: 0.9rem; letter-spacing: 1px; cursor: pointer;">SIMPAN PERUBAHAN</button>
        </div>
    </form>
  </div>
</div>

<script>
    // Logika Toggle Kuota
    function toggleQuota(enabled) {
        const container = document.getElementById('quota-container');
        const input = document.getElementById('quota');
        if (enabled) {
            container.style.display = 'block';
            input.setAttribute('required', 'required');
        } else {
            container.style.display = 'none';
            input.removeAttribute('required');
        }
    }

    // Logika Itinerary (Rundown)
    let rowCount = 0;
    const itineraryBody = document.getElementById('itinerary-body');
    const hiddenInput = document.getElementById('itinerary-hidden-input');

    function toggleBulkImport() {
        const area = document.getElementById('bulk-import-area');
        area.style.display = area.style.display === 'none' ? 'block' : 'none';
    }

    function processBulkImport() {
        const input = document.getElementById('bulk-input').value;
        if (!input.trim()) return;

        const lines = input.split('\n');
        lines.forEach(line => {
            if (!line.trim()) return;
            
            const timeRegex = /([0-9]{1,2}[:.][0-9]{2})\s*[-–]\s*([0-9]{1,2}[:.][0-9]{2})\s+(.*)/i;
            const match = line.match(timeRegex);
            
            if (match) {
                addItineraryRow(match[1], match[2], match[3]);
            } else {
                const simpleRegex = /([0-9]{1,2}[:.][0-9]{2})\s+(.*)/i;
                const simpleMatch = line.match(simpleRegex);
                if (simpleMatch) {
                    addItineraryRow(simpleMatch[1], '', simpleMatch[2]);
                } else {
                    addItineraryRow('', '', line);
                }
            }
        });
        
        document.getElementById('bulk-input').value = '';
        toggleBulkImport();
        updateJson();
    }

    function addItineraryRow(startTime = '', endTime = '', activity = '') {
        // Auto-fill startTime from last row's endTime if empty
        if (!startTime) {
            const lastEndInput = itineraryBody.querySelector('tr:last-child .itinerary-end');
            if (lastEndInput) {
                startTime = lastEndInput.value;
            }
        }

        rowCount++;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td style="padding: 12px; border: 1px solid #eee; text-align: center; color: #888;" class="row-number">${rowCount}</td>
            <td style="padding: 8px; border: 1px solid #eee;">
                <input type="text" class="itinerary-start" value="${startTime}" placeholder="08:00" style="width: 100%; padding: 8px; border: 1px solid #f0f0f0; border-radius: 0px;">
            </td>
            <td style="padding: 8px; border: 1px solid #eee;">
                <input type="text" class="itinerary-end" value="${endTime}" placeholder="09:00" style="width: 100%; padding: 8px; border: 1px solid #f0f0f0; border-radius: 0px;">
            </td>
            <td style="padding: 8px; border: 1px solid #eee;">
                <textarea class="itinerary-activity" placeholder="Ketik nama kegiatan..." rows="1" style="width: 100%; padding: 8px; border: 1px solid #f0f0f0; border-radius: 0px; font-family: inherit; resize: vertical;">${activity}</textarea>
            </td>
            <td style="padding: 8px; border: 1px solid #eee; text-align: center;">
                <button type="button" onclick="removeRow(this)" style="background: transparent; color: #e53e3e; border: none; cursor: pointer; padding: 5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </td>
        `;
        itineraryBody.appendChild(tr);
        
        // Add event listeners
        tr.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('input', updateJson);
        });
        updateJson();
    }

    function removeRow(btn) {
        btn.closest('tr').remove();
        updateRowNumbers();
        updateJson();
    }

    function updateRowNumbers() {
        const numbers = itineraryBody.querySelectorAll('.row-number');
        rowCount = 0;
        numbers.forEach((num, index) => {
            rowCount = index + 1;
            num.innerText = rowCount;
        });
    }

    function updateJson() {
        const rows = [];
        const starts = itineraryBody.querySelectorAll('.itinerary-start');
        const ends = itineraryBody.querySelectorAll('.itinerary-end');
        const activities = itineraryBody.querySelectorAll('.itinerary-activity');
        
        for (let i = 0; i < starts.length; i++) {
            if (starts[i].value || ends[i].value || activities[i].value) {
                rows.push({
                    start: starts[i].value,
                    end: ends[i].value,
                    activity: activities[i].value
                });
            }
        }
        hiddenInput.value = JSON.stringify(rows);
    }

    // Load existing data
    document.addEventListener('DOMContentLoaded', function() {
        const rawData = hiddenInput.value;
        let existingData = [];
        
        try {
            existingData = rawData ? JSON.parse(rawData) : [];
        } catch (e) {
            // Fallback for legacy text format
            if (rawData.trim()) {
                rawData.split('\n').forEach(line => {
                    const parts = line.split('-', 2);
                    existingData.push({
                        start: parts[0].trim(),
                        end: '',
                        activity: parts[1] ? parts[1].trim() : ''
                    });
                });
            }
        }

        if (Array.isArray(existingData) && existingData.length > 0) {
            existingData.forEach(item => {
                addItineraryRow(item.start || item.time || '', item.end || '', item.activity || '');
            });
        } else {
            addItineraryRow();
        }
    });
</script>
@endsection
