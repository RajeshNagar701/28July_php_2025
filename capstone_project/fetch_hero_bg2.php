<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Moody dark athletic sneaker background
$url = 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=1600&q=80'; 
$opts = [
    "http" => ["header" => "User-Agent: Mozilla/5.0\r\n"],
    "ssl"  => ["verify_peer" => false, "verify_peer_name" => false],
];
$context = stream_context_create($opts);

$contents = file_get_contents($url, false, $context);
if ($contents) {
    file_put_contents(storage_path('app/public/banners/hero_bg.jpg'), $contents);
    echo "New alternative background hero image downloaded successfully.\n";
} else {
    echo "Failed to download alternative background hero image.\n";
}
