<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BisaPlatformFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Siap Masuk');
        $response->assertSee('BiSA');
    }

    public function test_new_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Calon Mahasiswa UI',
            'email' => 'calon_ui@bisa.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', 'calon_ui@bisa.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals(UserRole::User, $user->role);
    }

    public function test_user_can_login_and_redirects_to_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::User,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_login_and_redirects_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::Admin,
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::User,
        ]);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_authenticated_user_can_view_learning_map(): void
    {
        $user = User::factory()->create(['role' => UserRole::User]);
        $category = Category::create([
            'name' => 'SNBT',
            'slug' => 'snbt',
            'order' => 1,
            'is_active' => true,
        ]);
        Subject::create([
            'category_id' => $category->id,
            'name' => 'Penalaran Umum',
            'slug' => 'penalaran-umum',
            'order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/peta-belajar/snbt');

        $response->assertStatus(200);
        $response->assertSee('Learning Adventure Map');
        $response->assertSee('Penalaran Umum');
    }

    public function test_user_can_complete_onboarding(): void
    {
        $user = User::factory()->create(['role' => UserRole::User]);

        $response = $this->actingAs($user)->post('/onboarding', [
            'target_ptn' => 'Institut Teknologi Bandung (ITB)',
            'target_major' => 'Teknik Informatika',
            'target_path' => 'snbt',
            'phone' => '081234567890',
        ]);

        $response->assertRedirect(route('dashboard'));
        $user->refresh();
        $this->assertEquals('Institut Teknologi Bandung (ITB)', $user->target_ptn);
        $this->assertTrue($user->onboarding_completed);
    }

    public function test_user_can_ask_kakai_tutor_ai(): void
    {
        $user = User::factory()->create(['role' => UserRole::User]);

        $response = $this->actingAs($user)->postJson('/kak-ai/ask', [
            'prompt' => 'Bagaimana cara cepat silogisme?',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonStructure(['reply' => ['summary', 'concept', 'speed_trick', 'analogy']]);
    }

    public function test_user_can_calculate_snbp_chance(): void
    {
        $user = User::factory()->create(['role' => UserRole::User]);

        $response = $this->actingAs($user)->post('/snbp/hitung', [
            'target_ptn' => 'Universitas Indonesia (UI)',
            'target_major' => 'Pendidikan Dokter',
            'avg_report_score' => 91.50,
            'school_accreditation' => 'A',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('analysis_result');
    }

    public function test_user_can_upgrade_to_premium(): void
    {
        $user = User::factory()->create(['role' => UserRole::User, 'is_premium' => false]);

        $response = $this->actingAs($user)->post('/pricing/checkout', [
            'plan_name' => 'Pejuang PTN Premium (3 Bulan)',
            'amount' => 49000,
            'payment_method' => 'QRIS',
        ]);

        $response->assertRedirect(route('dashboard'));
        $user->refresh();
        $this->assertTrue($user->is_premium);
    }
}
