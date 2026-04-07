<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'long_description',
        'image',
        'size_guide_image',
        'price',
        'discount_price',
        'discount_percent',
        'category_id',
        'stock',
        'status',
        'tag',
        'sku',
        'size',
        'outfit_type',
        'fabric',
        'includes',
        'design_details',
        'color',
        'disclaimer',
        'care_instructions',
        'youtube_link',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_tags',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'stock' => 'integer',
        'size' => 'array',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Calculate discount percent automatically.
     */
    public function calculateDiscountPercent()
    {
        if ($this->discount_price && $this->price > 0) {
            $this->discount_percent = round((($this->price - $this->discount_price) / $this->price) * 100, 2);
        } else {
            $this->discount_percent = null;
        }
    }

    /**
     * Scope to get only active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get only approved reviews for the product.
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    /**
     * Calculate average rating from approved reviews.
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
     * Get total approved reviews count.
     */
    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }
}
