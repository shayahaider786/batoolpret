<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Verified User in Fashion & Apparel"
            $table->integer('rating')->default(5); // 1-5 stars
            $table->text('description'); // The testimonial text
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('order')->default(0); // For custom ordering
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
