<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ====== ADMIN USER ======
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@shoestore.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '+91 98765 00001',
        ]);

        // ====== CUSTOMERS ======
        $customers = [
            ['name' => 'Rajesh Kumar',   'email' => 'rajesh@example.com',  'phone' => '+91 98765 43210'],
            ['name' => 'Priya Sharma',   'email' => 'priya@example.com',   'phone' => '+91 98765 43211'],
            ['name' => 'Amit Singh',     'email' => 'amit@example.com',    'phone' => '+91 98765 43212'],
            ['name' => 'Sunita Verma',   'email' => 'sunita@example.com',  'phone' => '+91 98765 43213'],
            ['name' => 'Rahul Gupta',    'email' => 'rahul@example.com',   'phone' => '+91 98765 43214'],
        ];

        foreach ($customers as $c) {
            User::create(array_merge($c, [
                'password' => Hash::make('password'),
                'role'     => 'customer',
                'address'  => '123 Main Street, Mumbai',
            ]));
        }

        // ====== CATEGORIES ======
        $categoryData = [
            ['name' => 'Running Shoes',    'image' => null],
            ['name' => 'Casual Sneakers',  'image' => null],
            ['name' => 'Formal Shoes',     'image' => null],
            ['name' => 'Sports Shoes',     'image' => null],
            ['name' => 'Sandals & Slippers', 'image' => null],
            ['name' => 'Boots',            'image' => null],
        ];

        $categories = [];
        foreach ($categoryData as $cat) {
            $categories[] = Category::create([
                'name'             => $cat['name'],
                'slug'             => Str::slug($cat['name']),
                'meta_title'       => $cat['name'] . ' - ShoeStore',
                'meta_description' => 'Buy premium ' . $cat['name'] . ' at ShoeStore. Best prices & quality.',
                'status'           => 1,
            ]);
        }

        // ====== PRODUCTS ======
        $products = [
            // Running Shoes
            ['name' => 'Nike Air Max 270',         'cat' => 0, 'price' => 8999, 'original' => 11999, 'qty' => 25, 'featured' => 1, 'sizes' => '6,7,8,9,10,11', 'colors' => 'Black,White,Blue'],
            ['name' => 'Adidas Ultraboost 22',     'cat' => 0, 'price' => 9499, 'original' => 12499, 'qty' => 18, 'featured' => 1, 'sizes' => '7,8,9,10,11',   'colors' => 'White,Black,Red'],
            ['name' => 'Puma Velocity Nitro',      'cat' => 0, 'price' => 5999, 'original' => 7999,  'qty' => 30, 'featured' => 0, 'sizes' => '6,7,8,9,10',    'colors' => 'Blue,Black'],
            ['name' => 'Skechers Go Run',          'cat' => 0, 'price' => 3499, 'original' => 4999,  'qty' => 40, 'featured' => 0, 'sizes' => '6,7,8,9,10,11', 'colors' => 'Grey,Black,White'],
            // Casual
            ['name' => 'Converse Chuck Taylor',    'cat' => 1, 'price' => 3999, 'original' => 5499,  'qty' => 35, 'featured' => 1, 'sizes' => '6,7,8,9,10',    'colors' => 'White,Black,Red'],
            ['name' => 'Vans Old Skool',           'cat' => 1, 'price' => 4499, 'original' => 5999,  'qty' => 22, 'featured' => 0, 'sizes' => '7,8,9,10,11',   'colors' => 'Black,White,Blue'],
            ['name' => 'Reebok Classic Leather',   'cat' => 1, 'price' => 4999, 'original' => 6499,  'qty' => 15, 'featured' => 0, 'sizes' => '6,7,8,9,10',    'colors' => 'White,Black'],
            // Formal
            ['name' => 'Bata Oxford Derby',        'cat' => 2, 'price' => 2999, 'original' => 3999,  'qty' => 20, 'featured' => 0, 'sizes' => '7,8,9,10,11',   'colors' => 'Black,Brown'],
            ['name' => 'Red Tape Formal Slip-on',  'cat' => 2, 'price' => 1999, 'original' => 2999,  'qty' => 25, 'featured' => 0, 'sizes' => '6,7,8,9,10',    'colors' => 'Black,Brown'],
            // Sports
            ['name' => 'Nike Court Legacy',        'cat' => 3, 'price' => 5499, 'original' => 7499,  'qty' => 28, 'featured' => 1, 'sizes' => '7,8,9,10,11',   'colors' => 'White,Black,Blue'],
            ['name' => 'Adidas Predator Edge',     'cat' => 3, 'price' => 6999, 'original' => 8999,  'qty' => 16, 'featured' => 0, 'sizes' => '6,7,8,9,10',    'colors' => 'Black,Red'],
            // Sandals
            ['name' => 'Nike Benassi JDI Slides',  'cat' => 4, 'price' => 1499, 'original' => 1999,  'qty' => 50, 'featured' => 0, 'sizes' => '6,7,8,9,10,11', 'colors' => 'Black,White,Red'],
            ['name' => 'Paragon Comfort Slippers', 'cat' => 4, 'price' => 399,  'original' => 599,   'qty' => 60, 'featured' => 0, 'sizes' => '6,7,8,9,10',    'colors' => 'Brown,Black'],
            // Boots
            ['name' => 'Woodland Ankle Boots',     'cat' => 5, 'price' => 4999, 'original' => 6999,  'qty' => 12, 'featured' => 1, 'sizes' => '7,8,9,10,11',   'colors' => 'Brown,Black'],
            ['name' => 'Timberland Premium Boot',  'cat' => 5, 'price' => 12999,'original' => 15999, 'qty' => 8,  'featured' => 1, 'sizes' => '8,9,10,11',      'colors' => 'Wheat,Black'],
        ];

        foreach ($products as $p) {
            Product::create([
                'category_id'      => $categories[$p['cat']]->id,
                'name'             => $p['name'],
                'slug'             => Str::slug($p['name']),
                'price'            => $p['price'],
                'original_price'   => $p['original'],
                'description'      => "Premium quality {$p['name']} crafted for comfort and style. Perfect for everyday use with durable materials and modern design.",
                'image'            => 'products/placeholder.png',
                'sizes'            => $p['sizes'],
                'colors'           => $p['colors'],
                'quantity'         => $p['qty'],
                'featured'         => $p['featured'],
                'status'           => 1,
                'meta_title'       => $p['name'] . ' - ShoeStore',
                'meta_description' => 'Buy ' . $p['name'] . ' at ShoeStore. Best price ₹' . $p['price'],
                'image_alt'        => $p['name'] . ' shoes',
            ]);
        }

        // ====== COUPONS ======
        $coupons = [
            ['code' => 'WELCOME10', 'discount' => 10, 'type' => 'percent', 'min_order' => 500,  'max_uses' => 100],
            ['code' => 'FLAT200',   'discount' => 200,'type' => 'fixed',   'min_order' => 1000, 'max_uses' => 50],
            ['code' => 'SAVE20',    'discount' => 20, 'type' => 'percent', 'min_order' => 2000, 'max_uses' => null],
        ];

        foreach ($coupons as $c) {
            Coupon::create(array_merge($c, [
                'valid_from'  => now(),
                'valid_until' => now()->addYear(),
                'status'      => 1,
            ]));
        }

        $this->command->info('✅ ShoeStore seeded successfully!');
        $this->command->info('👤 Admin: admin@shoestore.com / admin123');
        $this->command->info('👤 Customer: rajesh@example.com / password');
    }
}
