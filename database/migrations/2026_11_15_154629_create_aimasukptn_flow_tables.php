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
        // 1. Add onboarding & premium columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('target_ptn')->nullable()->after('role');
            $table->string('target_major')->nullable()->after('target_ptn');
            $table->string('target_path')->nullable()->default('snbt')->after('target_major');
            $table->string('phone')->nullable()->after('target_path');
            $table->boolean('is_premium')->default(false)->after('phone');
            $table->dateTime('premium_until')->nullable()->after('is_premium');
            $table->boolean('onboarding_completed')->default(false)->after('premium_until');
            $table->string('referral_code')->nullable()->unique()->after('onboarding_completed');
        });

        // 2. Tryout Events table
        Schema::create('tryout_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('event_type')->default('snbt'); // snbt, utbk, tka, mandiri
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('duration_minutes')->default(120);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_published')->default(true);
            $table->boolean('release_discussion')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. Tryout Registrations & Leaderboard
        Schema::create('tryout_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tryout_event_id')->constrained('tryout_events')->cascadeOnDelete();
            $table->foreignId('quiz_attempt_id')->nullable()->constrained('quiz_attempts')->nullOnDelete();
            $table->string('status')->default('registered'); // registered, in_progress, completed
            $table->decimal('score', 5, 2)->nullable();
            $table->decimal('irt_score', 5, 2)->nullable();
            $table->integer('national_rank')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'tryout_event_id']);
        });

        // 4. Live Classes table
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('instructor_name');
            $table->string('category_slug')->default('snbt');
            $table->dateTime('scheduled_at');
            $table->integer('duration_minutes')->default(90);
            $table->string('meet_url')->nullable();
            $table->string('recording_url')->nullable();
            $table->boolean('is_premium')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 5. Live Class Registrations
        Schema::create('live_class_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('live_class_id')->constrained('live_classes')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'live_class_id']);
        });

        // 6. SNBP Report Score Analyses
        Schema::create('snbp_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('target_ptn');
            $table->string('target_major');
            $table->decimal('avg_report_score', 4, 2);
            $table->integer('chance_percentage');
            $table->text('recommendation_text')->nullable();
            $table->timestamps();
        });

        // 7. Support & Moderation Tickets
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('question_id')->nullable()->constrained('questions')->nullOnDelete();
            $table->string('subject');
            $table->text('message');
            $table->text('admin_reply')->nullable();
            $table->string('status')->default('open'); // open, resolved, closed
            $table->timestamps();
        });

        // 8. Ambassador Applications
        Schema::create('ambassador_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('instagram_handle')->nullable();
            $table->string('tiktok_handle')->nullable();
            $table->string('school_name')->nullable();
            $table->text('motivation')->nullable();
            $table->string('referral_code')->unique();
            $table->string('status')->default('approved'); // pending, approved, rejected
            $table->integer('total_referrals')->default(0);
            $table->timestamps();
        });

        // 9. Premium Transactions
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('plan_name');
            $table->integer('amount');
            $table->string('payment_method');
            $table->string('status')->default('success'); // pending, success, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('ambassador_applications');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('snbp_analyses');
        Schema::dropIfExists('live_class_registrations');
        Schema::dropIfExists('live_classes');
        Schema::dropIfExists('tryout_registrations');
        Schema::dropIfExists('tryout_events');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'target_ptn',
                'target_major',
                'target_path',
                'phone',
                'is_premium',
                'premium_until',
                'onboarding_completed',
                'referral_code',
            ]);
        });
    }
};
