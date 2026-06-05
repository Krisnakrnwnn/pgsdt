@extends('layouts.admin')

@section('title', 'Tambah Berita - Admin Dalem Tarukan')

@section('content')
<div class="table-container news-edit-page">
  <div class="news-edit-inner">
    <h2 style="margin-bottom: 20px;">Tambah Berita Baru</h2>
  
    @if ($errors->any())
        <div style="background-color: #ffeaea; color: #d93025; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Judul Berita</label>
            <input type="text" name="title" value="{{ old('title') }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Kategori</label>
            <select name="category" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="">Berita (Umum)</option>
                <option value="pengumuman">Pengumuman</option>
                <option value="kegiatan">Kegiatan</option>
            </select>
            <small style="color: var(--text-dim);">Kosongkan untuk kategori umum/berita.</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Status</label>
            <select name="status" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="draft">Draf (Sembunyikan)</option>
                <option value="published">Terbit (Tampilkan)</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Konten Berita</label>
            <textarea name="content" rows="10" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required>{{ old('content') }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Tautan Video YouTube (Opsional)</label>
            <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=..." style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            <small style="color: var(--text-dim);">Masukkan tautan video YouTube jika berita ini menyertakan video.</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Gambar (Bisa pilih lebih dari satu)</label>
            <input type="file" name="images[]" multiple accept="image/*" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            <small style="color: var(--text-dim);">Gambar pertama akan otomatis menjadi cover/thumbnail berita.</small>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-primary">Simpan Berita</button>
            <a href="{{ route('admin.news.index') }}" style="padding: 10px 20px; background: #eee; color: #333; text-decoration: none; border-radius: 4px;">Batal</a>
        </div>
    </form>
  </div>
</div>
@endsection
