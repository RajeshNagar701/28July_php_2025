<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$url = 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=800&q=80'; // Bright blue dynamic sneaker
$opts = [
    "http" => ["header" => "User-Agent: Mozilla/5.0\r\n"],
    "ssl"  => ["verify_peer" => false, "verify_peer_name" => false],
];
$context = stream_context_create($opts);

if (!file_exists(storage_path('app/public/banners'))) {
    mkdir(storage_path('app/public/banners'), 0777, true);
}

$contents = file_get_contents($url, false, $context);
if ($contents) {
    file_put_contents(storage_path('app/public/banners/hero.jpg'), $contents);
    echo "New hero image downloaded successfully.\n";
} else {
    echo "Failed to download hero image.\n";
}
