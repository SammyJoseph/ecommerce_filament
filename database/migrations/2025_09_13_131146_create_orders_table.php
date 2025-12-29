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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('number', 32)->unique()->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('shipping_price', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->nullable();
            $table->enum('status', ['pending_payment', 'payment_confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending_payment');
            $table->string('currency')->default('pen');
            $table->foreignId('shipping_address_id')->nullable()->constrained('user_addresses')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
