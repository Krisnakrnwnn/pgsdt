<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NewsImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'image_path',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    /**
     * Hapus file dari storage saat record dihapus.
     */
    protected static function booted(): void
    {
        static::deleting(function (NewsImage $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }
}
