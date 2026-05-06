<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Cache duration in seconds
     */
    const CACHE_DURATION = 3600; // 1 hour
    const CACHE_DURATION_SHORT = 300; // 5 minutes
    const CACHE_DURATION_LONG = 86400; // 24 hours

    /**
     * Get latest news with caching
     */
    public static function getLatestNews($limit = 3)
    {
        return Cache::remember('latest_news_' . $limit, self::CACHE_DURATION, function () use ($limit) {
            return \App\Models\News::with('images')
                ->where('status', 'published')
                ->latest()
                ->take($limit)
                ->get();
        });
    }

    /**
     * Get featured event with caching
     */
    public static function getFeaturedEvent()
    {
        // Don't cache for now to avoid serialization issues
        return \App\Models\Agenda::where('is_featured', true)->first() 
               ?? \App\Models\Agenda::where('status', 'upcoming')
                                    ->where('event_date', '>=', now())
                                    ->orderBy('event_date', 'asc')
                                    ->first();
    }

    /**
     * Get upcoming events with caching
     */
    public static function getUpcomingEvents($limit = 10)
    {
        return Cache::remember('upcoming_events_' . $limit, self::CACHE_DURATION, function () use ($limit) {
            return \App\Models\Agenda::where('status', 'upcoming')
                ->where('event_date', '>=', now())
                ->orderBy('event_date', 'asc')
                ->take($limit)
                ->get();
        });
    }

    /**
     * Get member statistics with caching
     */
    public static function getMemberStats()
    {
        return Cache::remember('member_stats', self::CACHE_DURATION_SHORT, function () {
            return [
                'total' => \App\Models\User::where('role', 'member')->count(),
                'active' => \App\Models\User::where('role', 'member')->where('member_status', 'active')->count(),
                'pending' => \App\Models\User::where('role', 'member')->where('member_status', 'pending')->count(),
            ];
        });
    }

    /**
     * Clear all cache
     */
    public static function clearAll()
    {
        Cache::flush();
    }

    /**
     * Clear news cache
     */
    public static function clearNewsCache()
    {
        Cache::forget('latest_news_3');
        Cache::forget('latest_news_5');
        Cache::forget('latest_news_10');
        Cache::forget('sitemap_xml'); // Clear sitemap when news changes
    }

    /**
     * Clear event cache
     */
    public static function clearEventCache()
    {
        Cache::forget('featured_event');
        Cache::forget('upcoming_events_10');
        Cache::forget('upcoming_events_20');
        Cache::forget('sitemap_xml'); // Clear sitemap when events change
    }

    /**
     * Clear member cache
     */
    public static function clearMemberCache()
    {
        Cache::forget('member_stats');
    }
}
