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
        // Add indexes to products table for better query performance
        Schema::table('products', function (Blueprint $table) {
            // Index for tag filtering (new_arrival, trending, best_selling)
            $table->index('tag', 'products_tag_index');
            
            // Index for discount_price (used in sale filtering)
            $table->index('discount_price', 'products_discount_price_index');
            
            // Index for created_at (used in latest() ordering)
            $table->index('created_at', 'products_created_at_index');
            
            // Composite index for status and created_at (common query pattern)
            $table->index(['status', 'created_at'], 'products_status_created_at_index');
        });
        
        // Add indexes to orders table
        Schema::table('orders', function (Blueprint $table) {
            // Index for email (used in user order queries)
            $table->index('email', 'orders_email_index');
            
            // Index for status (used in filtering)
            $table->index('status', 'orders_status_index');
            
            // Composite index for user_id and status (common query pattern)
            $table->index(['user_id', 'status'], 'orders_user_id_status_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_tag_index');
            $table->dropIndex('products_discount_price_index');
            $table->dropIndex('products_created_at_index');
            $table->dropIndex('products_status_created_at_index');
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_email_index');
            $table->dropIndex('orders_status_index');
            $table->dropIndex('orders_user_id_status_index');
        });
    }
};
