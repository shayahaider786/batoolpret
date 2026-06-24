<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'status',
        'image',
        'banner_image',
        'category_link', // Add this field
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories (subcategories).
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get all subcategories recursively.
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Check if category is a parent (has no parent).
     */
    public function isParent()
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if category is a subcategory (has a parent).
     */
    public function isSubcategory()
    {
        return !is_null($this->parent_id);
    }

    /**
     * Get the category URL (either custom link or route)
     */
    public function getUrlAttribute()
    {
        if ($this->category_link) {
            return $this->category_link;
        }

        return route('shop', ['categories' => [$this->id]]);
    }

    /**
     * Scope to get only parent categories.
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get category by name or slug.
     */
    public static function findByName($name)
    {
        return self::where('name', 'LIKE', $name)
            ->orWhere('slug', 'LIKE', $name)
            ->active()
            ->first();
    }

    /**
     * Scope to get only subcategories.
     */
    public function scopeSubcategories($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Scope to get active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
