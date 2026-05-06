<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('images')->where('status', 'published');
        
        // Filter by category
        $category = $request->input('category');
        if ($category && in_array($category, ['pengumuman', 'kegiatan'])) {
            $query->where('category', $category);
        }
        
        // Search functionality - gunakan filled() bukan has() agar tidak proses string kosong
        $searchQuery = trim($request->input('search', ''));
        if ($searchQuery !== '') {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                  ->orWhere('content', 'like', '%' . $searchQuery . '%');
            });
        }
        
        $news = $query->latest()->paginate(12)->withQueryString();
        
        $currentCategory = $category ?? 'semua';
        
        return view('pages.news', compact('news', 'currentCategory', 'searchQuery'));
    }

    public function show($slug)
    {
        $newsItem = News::with('images')->where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('pages.news-detail', compact('newsItem'));
    }
}
