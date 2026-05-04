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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['new', 'processing', 'completed', 'cancelled'])->default('new');
            $table->decimal('total_price', 10, 2);
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('delivery_type')->nullable();
            $table->string('delivery_address')->nullable();
            $table->text('manager_comment')->nullable();
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
