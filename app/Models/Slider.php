<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_slider_image',
        'mobile_slider_image',
        'title',
        'description',
        'link',
    ];
}
