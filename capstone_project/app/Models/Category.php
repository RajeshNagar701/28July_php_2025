<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'meta_title', 'meta_description', 'status'];

    /** Auto-generate slug before saving */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /** Route model binding by slug */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /** Scope: only active categories */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
