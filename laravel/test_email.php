<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$u = App\Models\User::where('role', 'member')->latest()->first();
if ($u) {
    $u->sendEmailVerificationNotification();
    echo "Email sent for user ID: " . $u->id . "\n";
} else {
    echo "No member found\n";
}
