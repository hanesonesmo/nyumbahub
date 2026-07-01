<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$listing = App\Models\Listing::first();
echo "Before: " . $listing->status . "\n";
$listing->update(['status' => 'pending']);
echo "After: " . $listing->status . "\n";
