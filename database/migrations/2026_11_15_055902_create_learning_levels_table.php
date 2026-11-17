<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->integer('level_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['material', 'practice', 'quiz', 'tryout'])->default('practice');
            $table->integer('xp_reward')->default(50);
            $table->integer('min_score_to_unlock')->default(70);
            $table->integer('order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['subject_id', 'level_number']);
        });

        Schema::create('learning_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learning_level_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['locked', 'available', 'completed'])->default('locked');
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'learning_level_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_progress');
        Schema::dropIfExists('learning_levels');
    }
};
