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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->integer('stock')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('sku')->nullable();
            $table->enum('size', ['xs', 'S', 'M', 'L', 'XL', 'XXL'])->nullable();
            $table->string('outfit_type')->nullable();
            $table->text('fabric')->nullable();
            $table->text('includes')->nullable();
            $table->text('design_details')->nullable();
            $table->string('color')->nullable();
            $table->text('disclaimer')->nullable();
            $table->text('care_instructions')->nullable();
            $table->timestamps();

            $table->index('category_id');
            $table->index('status');
            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
