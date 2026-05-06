@extends('layouts.admin')

@section('title', 'Manajemen Berita - Admin Dalem Tarukan')

@section('content')
<div class="table-container news-page-table">
  <div class="table-header" style="padding: 25px; flex-wrap: wrap; gap: 15px;">
    <h2 class="table-title" style="margin: 0;">Manajemen Berita</h2>
    <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
      <form action="{{ route('admin.news.index') }}" method="GET" style="display: flex; gap: 8px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..."
               style="padding: 8px 14px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.85rem; width: 200px;">
        <select name="status" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.85rem; background: white;">
          <option value="">Semua Status</option>
          <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
          <option value="draft"     {{ request('status') == 'draft'     ? 'selected' : '' }}>Draft</option>
        </select>
        <button type="submit" class="btn-primary" style="padding: 8px 16px; font-size: 0.85rem;">CARI</button>
        @if(request('search') || request('status'))
          <a href="{{ route('admin.news.index') }}" style="padding: 8px 12px; background: #eee; border-radius: 4px; color: #666; text-decoration: none; font-size: 0.85rem;">✕</a>
        @endif
      </form>
      <a href="{{ route('admin.news.create') }}" class="btn-primary" style="text-decoration: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        TULIS BERITA BARU
      </a>
    </div>
  </div>

  @if(session('success'))
    {{-- Flash ditangani oleh global toast di layout --}}
  @endif

  <table class="data-table">
    <thead>
      <tr>
        <th class="col-no" style="width: 60px;">NO</th>
        <th class="col-info">Informasi Artikel</th>
        <th class="col-status" style="width: 150px;">Status</th>
        <th class="col-date" style="width: 150px;">Tanggal Terbit</th>
        <th class="col-aksi" style="width: 120px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($news as $item)
      <tr>
        <td class="col-no" style="text-align: center; font-weight: bold; color: var(--text-dim);">{{ $news->firstItem() + $loop->index }}</td>
        <td class="col-info">
            <a href="{{ route('admin.news.edit', $item->id) }}" style="text-decoration: none; display: block;">
                <div style="font-weight: 700; color: var(--primary-dark); font-size: 1rem; transition: color 0.2s;">{{ $item->title }}</div>
                <div style="margin-top: 5px;">
                    <span style="background: rgba(212,175,55,0.1); color: var(--accent-gold); padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
                        {{ $item->category ?? 'Berita' }}
                    </span>
                </div>
            </a>
        </td>
        <td class="col-status">
            @if($item->status == 'published')
                <span class="status-badge status-active" style="background: rgba(46, 204, 113, 0.15); color: #27ae60; font-weight: 700;">PUBLISHED</span>
            @else
                <span class="status-badge status-pending" style="background: rgba(127, 140, 141, 0.1); color: #7f8c8d; font-weight: 700;">DRAFT</span>
            @endif
        </td>
        <td class="col-date">
            <div style="font-weight: 600;">{{ $item->created_at->format('d M Y') }}</div>
            <div style="font-size: 0.7rem; color: #aaa;">{{ $item->created_at->format('H:i') }} WIB</div>
        </td>
        <td class="col-aksi">
          <div class="action-btns">
            <!-- Dropdown Menu -->
            <div class="dropdown-menu-container" style="position: relative;">
              <button class="btn-icon dropdown-toggle" onclick="toggleDropdown(event, {{ $item->id }})" title="Menu Aksi" style="background: none; border: none; cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
              </button>
              <div id="dropdown-{{ $item->id }}" class="dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 150px; z-index: 1000; margin-top: 5px;">
                <a href="{{ route('admin.news.edit', $item->id) }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px; text-decoration: none; color: var(--text-dark); transition: background 0.2s; border-bottom: 1px solid #f0f0f0;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  <span style="font-size: 0.85rem;">Edit</span>
                </a>
                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px; width: 100%; background: none; border: none; color: #e74c3c; cursor: pointer; transition: background 0.2s; text-align: left; font-family: inherit; font-size: 0.85rem;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                      <span>Hapus</span>
                    </button>
                </form>
              </div>
            </div>
          </div>
        </td>
      </tr>
      @empty
      <tr>
          <td colspan="5" style="text-align: center; padding: 60px 0; color: var(--text-dim);">
              <div style="font-size: 3rem; margin-bottom: 10px;">📰</div>
              Belum ada berita yang ditulis.
          </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  @if($news->hasPages())
  <div style="padding: 20px 25px; border-top: 1px solid #eee;">
    {{ $news->links() }}
  </div>
  @endif
</div>

<script>
// Dropdown functionality
function toggleDropdown(event, id) {
  event.stopPropagation();
  const dropdown = document.getElementById('dropdown-' + id);
  const allDropdowns = document.querySelectorAll('.dropdown-menu');
  
  // Close all other dropdowns
  allDropdowns.forEach(function(dd) {
    if (dd.id !== 'dropdown-' + id) {
      dd.style.display = 'none';
    }
  });
  
  // Toggle current dropdown
  if (dropdown.style.display === 'none' || dropdown.style.display === '') {
    dropdown.style.display = 'block';
  } else {
    dropdown.style.display = 'none';
  }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  const allDropdowns = document.querySelectorAll('.dropdown-menu');
  allDropdowns.forEach(function(dropdown) {
    dropdown.style.display = 'none';
  });
});

// Prevent dropdown from closing when clicking inside
document.querySelectorAll('.dropdown-menu').forEach(function(dropdown) {
  dropdown.addEventListener('click', function(event) {
    event.stopPropagation();
  });
});

// Hover effect for dropdown items
document.querySelectorAll('.dropdown-menu a, .dropdown-menu button').forEach(function(item) {
  item.addEventListener('mouseenter', function() {
    this.style.background = '#f5f5f5';
  });
  item.addEventListener('mouseleave', function() {
    this.style.background = 'transparent';
  });
});

// Force show action column on mobile
function handleResponsiveColumns() {
  const isMobile = window.innerWidth <= 768;
  
  if (isMobile) {
    // Force show all action cells
    const actionCells = document.querySelectorAll('.col-aksi');
    actionCells.forEach(function(cell) {
      cell.style.display = 'block !important';
      cell.style.visibility = 'visible !important';
      cell.style.opacity = '1 !important';
      cell.style.width = '15%';
      cell.style.float = 'left';
      cell.style.padding = '10px 6px';
      cell.style.textAlign = 'center';
    });
    
    // Force show dropdown containers
    const dropdowns = document.querySelectorAll('.dropdown-menu-container');
    dropdowns.forEach(function(dd) {
      dd.style.display = 'inline-block';
      dd.style.visibility = 'visible';
      dd.style.opacity = '1';
    });
    
    // Force show dropdown buttons
    const buttons = document.querySelectorAll('.dropdown-toggle');
    buttons.forEach(function(btn) {
      btn.style.display = 'inline-flex';
      btn.style.visibility = 'visible';
      btn.style.opacity = '1';
    });
    
    console.log('Mobile mode: Action columns forced to show');
  }
}

// Run on load
document.addEventListener('DOMContentLoaded', handleResponsiveColumns);

// Run immediately
handleResponsiveColumns();

// Run on resize
window.addEventListener('resize', handleResponsiveColumns);

// Run after delays to ensure DOM is ready
setTimeout(handleResponsiveColumns, 100);
setTimeout(handleResponsiveColumns, 500);
setTimeout(handleResponsiveColumns, 1000);
</script>
@endsection
