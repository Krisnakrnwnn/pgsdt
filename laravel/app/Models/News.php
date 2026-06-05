<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'status',
        'video_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the YouTube video ID from the video_url.
     */
    public function getYoutubeIdAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        $url = $this->video_url;
        $parts = parse_url($url);
        if (isset($parts['host'])) {
            if ($parts['host'] === 'youtu.be') {
                return ltrim($parts['path'], '/');
            }
            if (in_array($parts['host'], ['www.youtube.com', 'youtube.com', 'm.youtube.com'])) {
                if (isset($parts['query'])) {
                    parse_str($parts['query'], $query);
                    if (isset($query['v'])) {
                        return $query['v'];
                    }
                }
                if (strpos($parts['path'], '/embed/') === 0) {
                    return substr($parts['path'], 7);
                }
                if (strpos($parts['path'], '/v/') === 0) {
                    return substr($parts['path'], 3);
                }
            }
        }
        return null;
    }

    public function images()
    {
        return $this->hasMany(NewsImage::class);
    }

    /**
     * Cascade delete images saat news dihapus (termasuk soft delete force delete).
     */
    protected static function booted(): void
    {
        static::forceDeleting(function (News $news) {
            $news->images()->each(fn($img) => $img->delete());
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getExcerptAttribute()
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->content), 150);
    }
}
