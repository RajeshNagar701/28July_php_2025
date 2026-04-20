<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount', 'type', 'min_order',
        'max_uses', 'used_count', 'valid_from', 'valid_until', 'status',
    ];

    protected $casts = [
        'valid_from'  => 'date',
        'valid_until' => 'date',
    ];

    /** Check if coupon is currently valid */
    public function isValid(float $orderTotal = 0): bool
    {
        if (!$this->status) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->valid_from && Carbon::now()->lt($this->valid_from)) return false;
        if ($this->valid_until && Carbon::now()->gt($this->valid_until)) return false;
        if ($orderTotal < $this->min_order) return false;
        return true;
    }

    /** Calculate discount amount for a given total */
    public function calculateDiscount(float $total): float
    {
        if ($this->type === 'percent') {
            return round($total * ($this->discount / 100), 2);
        }
        return min($this->discount, $total); // Fixed, but not more than total
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
