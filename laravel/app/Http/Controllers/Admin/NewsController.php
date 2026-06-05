<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && in_array($request->status, ['draft', 'published'])) {
            $query->where('status', $request->status);
        }

        $news = $query->paginate(15)->withQueryString();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'nullable|in:pengumuman,kegiatan',
            'content'    => 'required|string|max:100000',
            'status'     => 'required|in:draft,published',
            'video_url'  => 'nullable|url|max:255',
            'images.*'   => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'images'     => 'nullable|array|max:10',
        ]);

        $slug = Str::slug($request->title) . '-' . time();

        $news = News::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->status,
            'video_url' => $request->video_url,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $this->storeCompressed($image, 'news_images');
                NewsImage::create([
                    'news_id' => $news->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'category'   => 'nullable|in:pengumuman,kegiatan',
            'content'    => 'required|string|max:100000',
            'status'     => 'required|in:draft,published',
            'video_url'  => 'nullable|url|max:255',
            'images.*'   => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'images'     => 'nullable|array|max:10',
        ]);

        if ($request->title !== $news->title) {
            $news->slug = Str::slug($request->title) . '-' . time();
        }

        $news->title = $request->title;
        $news->category = $request->category;
        $news->content = $request->content;
        $news->status = $request->status;
        $news->video_url = $request->video_url;
        $news->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $this->storeCompressed($image, 'news_images');
                NewsImage::create([
                    'news_id' => $news->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        foreach ($news->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function destroyImage(NewsImage $image)
    {
        $newsId = $image->news_id;
        
        // Hapus file fisik
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        // Hapus record database
        $image->delete();

        return redirect()->route('admin.news.edit', $newsId)->with('success', 'Gambar berhasil dihapus.');
    }

    /**
     * Simpan gambar dengan kompresi otomatis (max 1200px, JPEG quality 80)
     */
    private function storeCompressed($file, string $directory): string
    {
        $filename = $directory . '/' . Str::random(40) . '.jpg';
        $fullPath = storage_path('app/public/' . $filename);

        // Pastikan direktori ada
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Load gambar sesuai tipe
        $mime = $file->getMimeType();
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            $src = imagecreatefromjpeg($file->getRealPath());
        } elseif ($mime === 'image/png') {
            $src = imagecreatefrompng($file->getRealPath());
        } elseif ($mime === 'image/webp') {
            $src = imagecreatefromwebp($file->getRealPath());
        } else {
            // Fallback: simpan langsung tanpa kompresi
            return $file->store($directory, 'public');
        }

        // Resize jika lebih dari 1200px
        $origW = imagesx($src);
        $origH = imagesy($src);
        $maxW  = 1200;

        if ($origW > $maxW) {
            $ratio = $maxW / $origW;
            $newW  = $maxW;
            $newH  = (int)($origH * $ratio);
            $dst   = imagecreatetruecolor($newW, $newH);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
        } else {
            $dst = $src;
        }

        // Simpan sebagai JPEG quality 80
        imagejpeg($dst, $fullPath, 80);

        return $filename;
    }
}
