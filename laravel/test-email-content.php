<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Email Content ===\n\n";

// Get latest registration
$reg = \App\Models\AgendaRegistration::with(['user', 'agenda'])->latest()->first();

if (!$reg) {
    echo "No registrations found.\n";
    exit;
}

echo "Testing email for:\n";
echo "  User: {$reg->user->name}\n";
echo "  Email: {$reg->user->email}\n";
echo "  Event: {$reg->agenda->title}\n\n";

try {
    // Create notification
    $notification = new \App\Notifications\EventRegistrationNotification($reg->agenda, 'confirmed');
    
    // Get mail message
    $mailMessage = $notification->toMail($reg->user);
    
    echo "Email Details:\n";
    echo "  Subject: {$mailMessage->subject}\n";
    echo "  Greeting: {$mailMessage->greeting}\n";
    echo "  Lines: " . count($mailMessage->introLines) . "\n";
    echo "  Action: " . ($mailMessage->actionText ?? 'None') . "\n";
    echo "  Action URL: " . ($mailMessage->actionUrl ?? 'None') . "\n\n";
    
    echo "Email Content:\n";
    foreach ($mailMessage->introLines as $line) {
        echo "  - {$line}\n";
    }
    
    echo "\n✅ Email content looks good!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
}
