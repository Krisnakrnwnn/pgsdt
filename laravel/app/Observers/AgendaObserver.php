<?php

namespace App\Observers;

use App\Models\Agenda;
use App\Helpers\CacheHelper;

class AgendaObserver
{
    /**
     * Handle the Agenda "created" event.
     */
    public function created(Agenda $agenda): void
    {
        CacheHelper::clearEventCache();
    }

    /**
     * Handle the Agenda "updated" event.
     */
    public function updated(Agenda $agenda): void
    {
        CacheHelper::clearEventCache();
    }

    /**
     * Handle the Agenda "deleted" event.
     */
    public function deleted(Agenda $agenda): void
    {
        CacheHelper::clearEventCache();
    }

    /**
     * Handle the Agenda "restored" event.
     */
    public function restored(Agenda $agenda): void
    {
        CacheHelper::clearEventCache();
    }

    /**
     * Handle the Agenda "force deleted" event.
     */
    public function forceDeleted(Agenda $agenda): void
    {
        CacheHelper::clearEventCache();
    }
}
