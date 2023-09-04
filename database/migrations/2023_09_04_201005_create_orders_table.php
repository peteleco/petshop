<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('order_status_id')->constrained();
            $table->foreignId('payment_id')->constrained();
            $table->index(['user_id', 'order_status_id']);
            $table->uuid()->index();
            $table->json('products');
            $table->string('address');
            $table->float('delivery_fee', 8,2);
            $table->float('amount',12,2);
            $table->timestamp('shipped_at');

            $table->timestamps();
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
