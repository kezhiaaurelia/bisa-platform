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
            $table->string('question_type')->default('single')->after('learning_level_id');
            $table->string('image')->nullable()->after('question_text');
        });

        Schema::table('user_answers', function (Blueprint $table) {
            $table->json('selected_options')->nullable()->after('selected_option_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_answers', function (Blueprint $table) {
            $table->dropColumn('selected_options');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['question_type', 'image']);
        });
    }
};
