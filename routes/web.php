<?php

use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ImportController as AdminImportController;
use App\Http\Controllers\Admin\LiveClassController as AdminLiveClassController;
use App\Http\Controllers\Admin\ModerationController as AdminModerationController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\TryoutEventController as AdminTryoutEventController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\AiTutorController;
use App\Http\Controllers\User\AmbassadorController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\LearningMapController;
use App\Http\Controllers\User\LiveClassController;
use App\Http\Controllers\User\ModuleController;
use App\Http\Controllers\User\OnboardingController;
use App\Http\Controllers\User\PracticeController;
use App\Http\Controllers\User\PricingController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ProgressController;
use App\Http\Controllers\User\QuizController;
use App\Http\Controllers\User\ResultController;
use App\Http\Controllers\User\SnbpController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\TryoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Siswa & Umum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Onboarding Wizard (Target PTN, Jurusan, Jalur)
    Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');

    // 2. Learning Map (Adventure / Game Level Journey)
    Route::get('/peta-belajar/{categorySlug?}/{subjectSlug?}', [LearningMapController::class, 'show'])->name('map.show');

    // 3. Mode Latihan (Untimed, Instant Feedback, Immediate Explanation)
    Route::get('/latihan', [PracticeController::class, 'index'])->name('practice.index');
    Route::get('/latihan/mulai/{subjectId}', [PracticeController::class, 'start'])->name('practice.start');
    Route::get('/latihan/{attemptId}/soal/{qIndex?}', [PracticeController::class, 'show'])->name('practice.show');
    Route::post('/latihan/{attemptId}/jawab/{questionId}', [PracticeController::class, 'answer'])->name('practice.answer');
    Route::post('/latihan/{attemptId}/selesai', [PracticeController::class, 'finish'])->name('practice.finish');

    // 4. Mode Kuis (Timed, Configurable Duration, Silent During Quiz, Auto Submit)
    Route::get('/kuis', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/kuis/detail/{quizId}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/kuis/{quizId}/mulai', [QuizController::class, 'start'])->name('quiz.start');
    Route::get('/kuis/{attemptId}/pengerjaan/{qIndex?}', [QuizController::class, 'attempt'])->name('quiz.attempt');
    Route::post('/kuis/{attemptId}/jawab/{questionId}', [QuizController::class, 'saveAnswer'])->name('quiz.saveAnswer');
    Route::post('/kuis/{attemptId}/selesai', [QuizController::class, 'finish'])->name('quiz.finish');

    // 5. Tryout Akbar, Registrasi Event & Leaderboard Ranking Nasional
    Route::get('/tryout', [TryoutController::class, 'index'])->name('tryouts.index');
    Route::post('/tryout/event/{eventId}/daftar', [TryoutController::class, 'register'])->name('tryouts.register');
    Route::post('/tryout/event/{eventId}/mulai', [TryoutController::class, 'start'])->name('tryouts.start');
    Route::get('/tryout/event/{eventId}/leaderboard', [TryoutController::class, 'leaderboard'])->name('tryouts.leaderboard');

    // 6. KakAI (Tutor AI Interaktif 24/7)
    Route::get('/kak-ai', [AiTutorController::class, 'index'])->name('kakai.index');
    Route::post('/kak-ai/ask', [AiTutorController::class, 'ask'])->name('kakai.ask');

    // 7. Kelas Live Interaktif
    Route::get('/kelas-live', [LiveClassController::class, 'index'])->name('live-classes.index');
    Route::post('/kelas-live/{classId}/daftar', [LiveClassController::class, 'register'])->name('live-classes.register');

    // 8. SNBP Analisis (Rasionalisasi Nilai Rapor & Peluang PTN)
    Route::get('/snbp', [SnbpController::class, 'index'])->name('snbp.index');
    Route::post('/snbp/hitung', [SnbpController::class, 'calculate'])->name('snbp.calculate');

    // 9. Premium & Pricing Membership
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing.index');
    Route::post('/pricing/checkout', [PricingController::class, 'checkout'])->name('pricing.checkout');

    // 10. Profil Siswa
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    // 11. Program Ambassador & Komunitas
    Route::get('/ambassador', [AmbassadorController::class, 'index'])->name('ambassador.index');
    Route::post('/ambassador/daftar', [AmbassadorController::class, 'apply'])->name('ambassador.apply');

    // 12. Bantuan & FAQ
    Route::get('/bantuan', [SupportController::class, 'index'])->name('support.index');
    Route::post('/bantuan/kirim', [SupportController::class, 'store'])->name('support.store');

    // 13. Results & Review Pembahasan
    Route::get('/hasil/{attemptId}', [ResultController::class, 'show'])->name('results.show');

    // 14. Modul Pembelajaran
    Route::get('/modul', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modul/{moduleId}', [ModuleController::class, 'show'])->name('module.show');
    Route::post('/modul/{moduleId}/selesai', [ModuleController::class, 'complete'])->name('module.complete');

    // 15. Progress Belajar Siswa
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
});

/*
|--------------------------------------------------------------------------
| Administrator Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelola Pengguna
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/toggle-premium', [AdminUserController::class, 'togglePremium'])->name('users.togglePremium');
    Route::post('/users/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.resetPassword');

    // Master Akademik
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('subjects', AdminSubjectController::class);

    // Bank Soal
    Route::post('questions/ai-explanation', [AdminQuestionController::class, 'generateAiExplanation'])->name('questions.aiExplanation');
    Route::resource('questions', AdminQuestionController::class);

    // Kuis & Tryout Standalone
    Route::resource('quizzes', AdminQuizController::class);

    // Kelola Event Tryout Nasional
    Route::resource('tryout-events', AdminTryoutEventController::class);

    // Kelola Kelas Live
    Route::resource('live-classes', AdminLiveClassController::class);

    // Kelola Transaksi & Pembayaran Premium
    Route::get('transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');

    // Moderasi & Laporan Siswa
    Route::get('moderation', [AdminModerationController::class, 'index'])->name('moderation.index');
    Route::post('moderation/{id}/reply', [AdminModerationController::class, 'reply'])->name('moderation.reply');

    // Laporan & Analitik
    Route::get('analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');

    // Excel Import
    Route::get('import', [AdminImportController::class, 'index'])->name('import.index');
    Route::get('import/template', [AdminImportController::class, 'downloadTemplate'])->name('import.template');
    Route::post('import', [AdminImportController::class, 'store'])->name('import.store');
});
