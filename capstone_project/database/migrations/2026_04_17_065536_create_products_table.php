<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable(); // For showing discounts
            $table->text('description')->nullable();
            $table->string('image'); // Main product image
            $table->json('gallery')->nullable(); // Additional images
            $table->string('sizes')->nullable(); // e.g. "6,7,8,9,10,11"
            $table->string('colors')->nullable(); // e.g. "Red,Blue,Black"
            $table->integer('quantity')->default(0);
            $table->boolean('featured')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('image_alt')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
