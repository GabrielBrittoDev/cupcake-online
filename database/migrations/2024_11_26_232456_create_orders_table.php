<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clientId')->constrained('clients');
            $table->foreignId('addressId')->constrained('addresses');
            $table->decimal('total', 10);
            $table->text('observation')->nullable();
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'canceled',
            ]);
            $table->enum('deliveryType', [
                'pickup',
                'delivery',
            ]);
            $table->dateTime('deliveredAt')->nullable();
            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
