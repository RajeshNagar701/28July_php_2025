<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$p = \App\Models\Product::where('name', 'like', '%Adidas Predator Edge%')->first();
if ($p) {
    // A distinct high-quality Adidas sports shoe image from Unsplash
    $url = 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=600&q=80'; 
    $opts = [
        "http" => ["header" => "User-Agent: Mozilla/5.0\r\n"],
        "ssl"  => ["verify_peer" => false, "verify_peer_name" => false]
    ];
    $context = stream_context_create($opts);
    $contents = file_get_contents($url, false, $context);
    if ($contents) {
        $filename = 'product_' . $p->id . '_adidas.jpg';
        file_put_contents(storage_path('app/public/products/' . $filename), $contents);
        $p->image = 'products/' . $filename;
        $p->save();
        echo "Successfully updated Image for: " . $p->name . "\n";
    } else {
        echo "Failed to fetch image contents.\n";
    }
} else {
    echo "Product not found.\n";
}
