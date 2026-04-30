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
        Schema::table('questions', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['subject', 'topic', 'category']);
            
            // Add new foreign key
            $table->foreignId('topic_id')->nullable()->after('text')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('topic_id');
            $table->string('subject')->nullable();
            $table->string('topic')->nullable();
            $table->string('category')->nullable();
        });
    }
};
