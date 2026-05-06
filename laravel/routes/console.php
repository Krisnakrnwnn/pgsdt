<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule event reminders to run daily at 9:00 AM WITA
$schedule = Schedule::command('event:send-reminders')
    ->dailyAt('09:00')
    ->timezone('Asia/Makassar');

// Kirim notifikasi jika gagal, hanya jika MAIL_FROM_ADDRESS sudah dikonfigurasi
$fromAddress = config('mail.from.address');
if ($fromAddress && $fromAddress !== 'hello@example.com') {
    $schedule->emailOutputOnFailure($fromAddress);
}
