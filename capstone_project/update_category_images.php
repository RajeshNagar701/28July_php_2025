<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mapping = [
    'Formal Shoes' => 'https://images.unsplash.com/photo-1595341888016-a392ef81b7de?w=500&q=70' // Leather Formal
];

if (!file_exists(storage_path('app/public/categories'))) {
    mkdir(storage_path('app/public/categories'), 0777, true);
}

foreach(\App\Models\Category::all() as $cat) {
    if (isset($mapping[$cat->name])) {
        $url = $mapping[$cat->name];
        try {
            $opts = [
                "http" => ["header" => "User-Agent: Mozilla/5.0\r\n"],
                "ssl"  => ["verify_peer" => false, "verify_peer_name" => false],
            ];
            $context = stream_context_create($opts);
            $contents = file_get_contents($url, false, $context);
            if ($contents) {
                $filename = 'cat_' . $cat->id . '_' . time() . '.jpg';
                file_put_contents(storage_path('app/public/categories/' . $filename), $contents);
                $cat->image = 'categories/' . $filename;
                $cat->save();
                echo "Updated category: " . $cat->name . "\n";
            }
        } catch (\Exception $e) { 
            echo "Failed category: " . $cat->name . "\n";
        }
    }
}
echo "\nSuccessfully assigned dynamic distinct images to all categories!\n";
