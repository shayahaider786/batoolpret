<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Change column type from enum to text first (to allow data conversion)
        Schema::table('products', function (Blueprint $table) {
            $table->text('size')->nullable()->change();
        });

        // Step 2: Convert existing single size values to JSON array format
        $products = DB::table('products')->whereNotNull('size')->get();
        foreach ($products as $product) {
            $size = $product->size;
            // Check if it's already JSON, if not convert single value to JSON array
            $decoded = json_decode($size, true);
            if (!is_array($decoded)) {
                // Convert single enum value to JSON array
                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['size' => json_encode([$size])]);
            }
        }

        // Step 3: Change column type from text to JSON
        Schema::table('products', function (Blueprint $table) {
            $table->json('size')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('size', ['xs', 'S', 'M', 'L', 'XL', 'XXL'])->nullable()->change();
        });
    }
};
