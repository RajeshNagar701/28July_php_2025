<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$images = [
    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80',
    'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=600&q=80',
    'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=600&q=80',
    'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=600&q=80',
    'https://images.unsplash.com/photo-1514989940723-e8e51635b782?w=600&q=80',
    'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=600&q=80',
    'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=600&q=80',
    'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=600&q=80',
    'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=600&q=80',
    'https://images.unsplash.com/photo-1588099768523-f4e6a5679d88?w=600&q=80',
    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&q=80',
    'https://images.unsplash.com/photo-1511556532299-8f662fc26c06?w=600&q=80'
];

$products = \App\Models\Product::all();
$count = 0;

if (!file_exists(storage_path('app/public/products'))) {
    mkdir(storage_path('app/public/products'), 0777, true);
}

foreach($products as $p) {
    if ($count >= count($images)) $count = 0;
    
    $url = $images[$count];
    try {
        $opts = [
            "http" => ["header" => "User-Agent: Mozilla/5.0\r\n"],
            "ssl"  => ["verify_peer" => false, "verify_peer_name" => false],
        ];
        $context = stream_context_create($opts);
        $contents = file_get_contents($url, false, $context);
        if ($contents) {
            $filename = 'product_' . $p->id . '_' . time() . '.jpg';
            file_put_contents(storage_path('app/public/products/' . $filename), $contents);
            $p->image = 'products/' . $filename;
            $p->save();
            echo "Updated product ID: " . $p->id . "\n";
        }
    } catch (\Exception $e) { 
        echo "Failed product ID: " . $p->id . "\n";
    }
    $count++;
}
echo "\nSuccessfully assigned dynamic distinct images to all products!\n";
