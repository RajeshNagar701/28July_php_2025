<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$u = User::where('email', 'admin@shoestore.com')->first();
if ($u) {
    $u->password = Hash::make('admin@123');
    $u->save();
    echo "ADMIN_PASSWORD_RESET_SUCCESS\n";
} else {
    echo "ADMIN_NOT_FOUND\n";
}
