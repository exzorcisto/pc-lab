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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('component_id')->nullable()->constrained()->onDelete('set null');
            $table->string('component_name'); // Копия имени на момент покупки[cite: 1]
            $table->integer('quantity')->default(1);
            $table->decimal('price_at_purchase', 10, 2); // Фиксация цены[cite: 1]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
