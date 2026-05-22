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
        // Если таблица еще не создана, создаем ее
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->integer('rating')->unsigned();
                $table->text('text');
                $table->string('status')->default('pending'); // pending, published, rejected
                $table->text('admin_comment')->nullable(); // Поле для причины отклонения
                $table->timestamps();
            });
        } else {
            // Если таблица уже есть, добавляем недостающие поля через Schema::table
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('text');
                $table->text('admin_comment')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['status', 'admin_comment']);
        });
    }
};