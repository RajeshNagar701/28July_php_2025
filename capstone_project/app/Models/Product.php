<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'price', 'original_price',
        'description', 'image', 'gallery', 'sizes', 'colors',
        'quantity', 'featured', 'meta_title', 'meta_description',
        'image_alt', 'status',
    ];

    protected $casts = [
        'gallery'  => 'array',
        'featured' => 'boolean',
        'status'   => 'boolean',
    ];

    /** Auto-generate slug before saving */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /** Route model binding by slug */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Get sizes as array */
    public function getSizesArrayAttribute(): array
    {
        return $this->sizes ? explode(',', $this->sizes) : [];
    }

    /** Get colors as array */
    public function getColorsArrayAttribute(): array
    {
        return $this->colors ? explode(',', $this->colors) : [];
    }

    /** Check if product has a discount */
    public function hasDiscount(): bool
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /** Get discount percentage */
    public function getDiscountPercentAttribute(): int
    {
        if (!$this->hasDiscount()) return 0;
        return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    /** Average rating */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->where('approved', 1)->avg('rating') ?? 0;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
