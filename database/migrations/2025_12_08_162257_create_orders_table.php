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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('session_id')->nullable(); // For guest orders
            $table->string('order_number')->unique();

            // Billing Details
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name')->nullable();
            $table->string('address');
            $table->string('apartment')->nullable();
            $table->string('state_country')->nullable();
            $table->string('postal_zip')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('order_notes')->nullable();

            // Order Totals
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);

            // Order Status
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->string('payment_method')->default('cash_on_delivery');

            $table->timestamps();

            $table->index('order_number');
            $table->index('user_id');
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
