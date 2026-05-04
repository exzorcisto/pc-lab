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
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('image_url')->nullable();
            $table->string('socket')->nullable(); // Для CPU/MB
            $table->string('ram_type')->nullable(); // DDR4/DDR5
            $table->integer('tdp')->nullable(); // Энергопотребление
            $table->string('form_factor')->nullable(); // ATX, mATX
            $table->json('specifications')->nullable(); // Все остальные доп. параметры
            $table->integer('performance_index')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
