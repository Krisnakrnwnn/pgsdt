@extends('layouts.admin')

@section('title', 'Edit Berita - Admin Dalem Tarukan')

@section('content')
<div class="table-container news-edit-page">
  <div class="news-edit-inner">
    <h2 style="margin-bottom: 20px;">Edit Berita</h2>
  
    @if ($errors->any())
        <div style="background-color: #ffeaea; color: #d93025; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Judul Berita</label>
            <input type="text" name="title" value="{{ old('title', $news->title) }}" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Kategori</label>
            <select name="category" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="" {{ !$news->category ? 'selected' : '' }}>Berita (Umum)</option>
                <option value="pengumuman" {{ $news->category == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                <option value="kegiatan" {{ $news->category == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
            </select>
            <small style="color: var(--text-dim);">Kosongkan untuk kategori umum/berita.</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Status</label>
            <select name="status" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
                <option value="draft" {{ $news->status == 'draft' ? 'selected' : '' }}>Draf (Sembunyikan)</option>
                <option value="published" {{ $news->status == 'published' ? 'selected' : '' }}>Terbit (Tampilkan)</option>
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Konten Berita</label>
            <textarea name="content" rows="10" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;" required>{{ old('content', $news->content) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Tambahkan Gambar (Opsional)</label>
            <input type="file" name="images[]" multiple accept="image/*" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
            <small style="color: var(--text-dim);">Gambar yang diunggah di sini akan ditambahkan ke galeri berita.</small>
        </div>

        @if($news->images->count() > 0)
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Gambar Tersimpan</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px;">
                @foreach($news->images as $img)
                    <div style="position: relative; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; background: #f9f9f9;">
                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="News Image" style="width: 100%; height: 100px; object-fit: cover; display: block;">
                        <div style="padding: 5px; background: rgba(255,255,255,0.9); border-top: 1px solid #ddd; text-align: center;">
                            <button type="button" 
                                    onclick="if(confirm('Hapus gambar ini?')) { document.getElementById('delete-img-{{ $img->id }}').submit(); }" 
                                    style="background: #e74c3c; color: white; border: none; padding: 4px 10px; border-radius: 3px; font-size: 0.7rem; cursor: pointer; font-weight: 600;">
                                HAPUS
                            </button>
                        </div>
                        <form id="delete-img-{{ $img->id }}" action="{{ route('admin.news.images.destroy', $img->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-primary">Perbarui Berita</button>
            <a href="{{ route('admin.news.index') }}" style="padding: 10px 20px; background: #eee; color: #333; text-decoration: none; border-radius: 4px;">Batal</a>
        </div>
    </form>
  </div>
</div>
@endsection
