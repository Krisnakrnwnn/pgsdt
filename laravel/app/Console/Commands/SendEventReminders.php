<?php

namespace App\Console\Commands;

use App\Models\Agenda;
use App\Models\AgendaRegistration;
use App\Notifications\EventReminderNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to users for events happening tomorrow (H-1)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for events happening tomorrow...');
        
        // Get tomorrow's date (start and end of day)
        $tomorrow = Carbon::tomorrow()->startOfDay();
        $tomorrowEnd = Carbon::tomorrow()->endOfDay();
        
        // Find events happening tomorrow
        $events = Agenda::whereBetween('event_date', [$tomorrow, $tomorrowEnd])
            ->where('status', 'upcoming')
            ->get();
        
        if ($events->isEmpty()) {
            $this->info('No events found for tomorrow.');
            return 0;
        }
        
        $this->info("Found {$events->count()} event(s) happening tomorrow.");
        
        $totalSent = 0;
        
        foreach ($events as $event) {
            $this->info("Processing event: {$event->title}");
            
            // Get confirmed registrations for this event
            $registrations = AgendaRegistration::where('agenda_id', $event->id)
                ->where('status', 'confirmed')
                ->with('user')
                ->get();
            
            if ($registrations->isEmpty()) {
                $this->warn("  No confirmed registrations for this event.");
                continue;
            }
            
            $this->info("  Sending reminders to {$registrations->count()} participant(s)...");
            
            foreach ($registrations as $registration) {
                try {
                    // Skip jika user tidak ada atau email belum terverifikasi
                    if (!$registration->user || !$registration->user->hasVerifiedEmail()) {
                        $this->warn("    ⚠ Skipped: " . ($registration->user->name ?? 'Unknown') . " (email not verified)");
                        continue;
                    }

                    // Send reminder notification
                    $registration->user->notify(new EventReminderNotification($event));
                    $totalSent++;
                    $this->info("    ✓ Sent to: {$registration->user->name} ({$registration->user->email})");
                } catch (\Exception $e) {
                    $this->error("    ✗ Failed to send to: " . ($registration->user->name ?? 'Unknown') . " - {$e->getMessage()}");
                }
            }
        }
        
        $this->info("\n✅ Reminder process completed!");
        $this->info("Total reminders sent: {$totalSent}");
        
        return 0;
    }
}
