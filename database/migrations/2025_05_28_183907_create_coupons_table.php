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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percentage']); // Tipo de descuento
            $table->decimal('value', 8, 2); // Valor del descuento (monto fijo o porcentaje)
            $table->decimal('min_cart_amount', 10, 2)->nullable(); // Monto mínimo del carrito para aplicar
            $table->timestamp('expires_at')->nullable(); // Fecha de expiración
            $table->unsignedInteger('usage_limit')->nullable(); // Límite de usos totales
            $table->unsignedInteger('times_used')->default(0); // Veces que se ha usado
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
