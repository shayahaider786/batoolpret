<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'discount_percent',
        'status',
        'valid_from',
        'valid_until',
        'usage_limit',
        'used_count',
        'description',
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];

    /**
     * Check if coupon is valid.
     */
    public function isValid()
    {
        // Check status
        if ($this->status !== 'active') {
            return false;
        }

        // Check date validity
        $now = Carbon::now();
        if ($this->valid_from && $now->lt($this->valid_from)) {
            return false;
        }
        if ($this->valid_until && $now->gt($this->valid_until)) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Increment usage count.
     */
    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}
