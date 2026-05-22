<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saved_builds', function (Blueprint $table) {
            // Имя сборки ("TITAN" или "#C-123456")
            $table->string('name')->nullable()->after('user_id'); 
            
            // Ссылка на шаблон (если это сборка на базе пресета)
            $table->foreignId('template_id')
                  ->nullable()
                  ->after('name')
                  ->constrained('build_templates')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('saved_builds', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropColumn(['name', 'template_id']);
        });
    }
};