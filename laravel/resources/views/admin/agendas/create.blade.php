@extends('layouts.admin')

@section('title', 'Tambah Agenda - Admin Dalem Tarukan')

@section('content')
<div class="form-container agenda-edit-page">
  <div class="agenda-edit-inner">
    <h2 style="margin-bottom: 25px; color: var(--primary-dark); font-family: 'Cinzel', serif;">Tambah Agenda Baru</h2>

    @if ($errors->any())
        <div style="padding: 15px; background: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.agendas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Nama Acara / Agenda <span style="color: red;">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;">
        </div>

        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <label for="event_date" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Tanggal & Waktu <span style="color: red;">*</span></label>
                <input type="datetime-local" id="event_date" name="event_date" value="{{ old('event_date') }}" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;">
            </div>
            <div style="flex: 1;">
                <label for="status" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Status Agenda <span style="color: red;">*</span></label>
                <select id="status" name="status" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit; background: white;">
                    <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Mendatang (Upcoming)</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
            </div>
            <div style="flex: 1; display: flex; align-items: flex-end; padding-bottom: 12px; gap: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 500; color: var(--text-dark);">
                    <input type="checkbox" id="registration_enabled" name="registration_enabled" value="1" checked onchange="toggleQuota(this.checked)" style="width: 18px; height: 18px;">
                    Aktifkan Pendaftaran
                </label>
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 500; color: var(--accent-gold); border-left: 1px solid #ddd; padding-left: 20px;">
                    <input type="checkbox" name="is_featured" value="1" style="width: 18px; height: 18px;">
                    ⭐ Jadikan Agenda Utama
                </label>
            </div>
            <div id="quota-container" style="flex: 1; {{ old('registration_enabled', 1) ? '' : 'display: none;' }}">
                <label for="quota" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Kuota Peserta</label>
                <input type="number" id="quota" name="quota" value="{{ old('quota', 1500) }}" min="0" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;">
            </div>
        </div>

        <script>
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
        </script>

        <div style="margin-bottom: 20px;">
            <label for="location" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Lokasi Acara</label>
            <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Pura Dalem Tarukan Pusat" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="location_map" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Link Google Maps</label>
            <input type="text" id="location_map" name="location_map" value="{{ old('location_map') }}" placeholder="Tempel link dari Google Maps di sini" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;">
            <small style="color: #666; display: block; margin-top: 5px;">Buka Google Maps > Klik Bagikan > Salin Link/Tautan > Tempel di sini.</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="image" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Poster / Foto Sampul</label>
            <input type="file" id="image" name="image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background: #f9f9f9;">
            <small style="color: var(--text-dim); display: block; margin-top: 5px;">Format: JPG, PNG, WEBP. Maks: 2MB.</small>
        </div>

        <div style="margin-bottom: 25px; background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #eee;">
            <label style="display: block; margin-bottom: 15px; font-weight: 600; color: var(--text-dark); font-size: 1.1rem; font-family: 'Cinzel', serif;">Jadwal Acara / Rundown</label>
            
            <table id="itinerary-table" style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
                <thead>
                    <tr style="text-align: left; background: #eee;">
                        <th style="padding: 10px; border: 1px solid #ddd; width: 60px;">No</th>
                        <th style="padding: 10px; border: 1px solid #ddd; width: 120px;">Mulai</th>
                        <th style="padding: 10px; border: 1px solid #ddd; width: 120px;">Selesai</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Kegiatan / Acara</th>
                        <th style="padding: 10px; border: 1px solid #ddd; width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="itinerary-body">
                    <!-- Rows will be added here by JS -->
                </tbody>
            </table>
            
            <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                <button type="button" onclick="addItineraryRow()" style="padding: 8px 16px; background: var(--accent-gold); color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Baris
                </button>
                <button type="button" onclick="toggleBulkImport()" style="padding: 8px 16px; background: #666; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                    Impor Sekaligus (Paste)
                </button>
            </div>

            <!-- Bulk Import Area (Hidden by default) -->
            <div id="bulk-import-area" style="display: none; margin-bottom: 20px; background: #eee; padding: 15px; border-radius: 8px;">
                <label style="display: block; margin-bottom: 10px; font-weight: 600;">Tempel Jadwal Anda di sini:</label>
                <textarea id="bulk-input" rows="5" placeholder="Contoh:&#10;08.00 - 08.30 Registrasi&#10;08.30 - 09.00 Pembukaan" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; font-family: monospace;"></textarea>
                <div style="margin-top: 10px; display: flex; gap: 10px;">
                    <button type="button" onclick="processBulkImport()" style="padding: 5px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">Proses Impor</button>
                    <button type="button" onclick="toggleBulkImport()" style="padding: 5px 15px; background: #999; color: white; border: none; border-radius: 4px; cursor: pointer;">Batal</button>
                </div>
                <small style="display: block; margin-top: 5px; color: #666;">Format: 08.00 - 09.00 Nama Kegiatan (Gunakan pemisah '-' atau spasi)</small>
            </div>

            <input type="hidden" name="itinerary" id="itinerary-hidden-input">
        </div>

        <script>
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
                    
                    // Regex to extract time and activity
                    // Matches formats like "08:00 - 09:00 Activity" or "08.00-09.00 Activity"
                    const timeRegex = /([0-9]{1,2}[:.][0-9]{2})\s*[-–]\s*([0-9]{1,2}[:.][0-9]{2})\s+(.*)/i;
                    const match = line.match(timeRegex);
                    
                    if (match) {
                        addItineraryRow(match[1], match[2], match[3]);
                    } else {
                        // Fallback if format is just "Time Activity"
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
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;" class="row-number">${rowCount}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <input type="text" class="itinerary-start" value="${startTime}" placeholder="08:00" style="width: 100%; padding: 8px; border: 1px solid #eee; border-radius: 4px;">
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <input type="text" class="itinerary-end" value="${endTime}" placeholder="09:00" style="width: 100%; padding: 8px; border: 1px solid #eee; border-radius: 4px;">
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <textarea class="itinerary-activity" placeholder="Nama Kegiatan" rows="2" style="width: 100%; padding: 8px; border: 1px solid #eee; border-radius: 4px; font-family: inherit; resize: vertical;">${activity}</textarea>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <button type="button" onclick="removeRow(this)" style="background: #ff4d4d; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Hapus</button>
                    </td>
                `;
                itineraryBody.appendChild(tr);
                
                // Add event listeners to inputs and textareas
                tr.querySelectorAll('input, textarea').forEach(input => {
                    input.addEventListener('input', updateJson);
                });
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

            // Add first row by default
            addItineraryRow();
        </script>

        <div style="margin-bottom: 25px;">
            <label for="description" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-dark);">Detail & Deskripsi Acara <span style="color: red;">*</span></label>
            <textarea id="description" name="description" rows="6" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit; resize: vertical;">{{ old('description') }}</textarea>
        </div>

        <div style="display: flex; gap: 15px; justify-content: flex-end;">
            <a href="{{ route('admin.agendas.index') }}" style="padding: 12px 24px; border: 1px solid #ddd; border-radius: 4px; color: var(--text-dark); text-decoration: none; font-weight: 500;">Batal</a>
            <button type="submit" class="btn-primary" style="border: none; cursor: pointer;">Simpan Agenda</button>
        </div>
    </form>
  </div>
</div>
@endsection
