<?php

namespace App\Observers;

use App\Models\News;
use App\Helpers\CacheHelper;

class NewsObserver
{
    /**
     * Handle the News "created" event.
     */
    public function created(News $news): void
    {
        CacheHelper::clearNewsCache();
    }

    /**
     * Handle the News "updated" event.
     */
    public function updated(News $news): void
    {
        CacheHelper::clearNewsCache();
    }

    /**
     * Handle the News "deleted" event.
     */
    public function deleted(News $news): void
    {
        CacheHelper::clearNewsCache();
    }

    /**
     * Handle the News "restored" event.
     */
    public function restored(News $news): void
    {
        CacheHelper::clearNewsCache();
    }

    /**
     * Handle the News "force deleted" event.
     */
    public function forceDeleted(News $news): void
    {
        CacheHelper::clearNewsCache();
    }
}
