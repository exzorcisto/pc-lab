<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('service_type'); // upgrade, maintenance, partnership
            $table->string('preferred_time'); // 9:00-11:30 и т.д.
            $table->text('comment')->nullable();
            
            // Поля для администратора
            $table->decimal('price', 10, 2)->nullable();
            $table->text('admin_note')->nullable();
            $table->enum('status', ['new', 'in_progress', 'awaiting_payment', 'resolved', 'cancelled'])->default('new');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};