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
        Schema::create('saved_build_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saved_build_id')->constrained('saved_builds')->onDelete('cascade');
            $table->foreignId('component_id')->constrained('components')->onDelete('cascade');
            $table->integer('quantity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_build_items');
    }
};
