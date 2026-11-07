<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_landing_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('CodeCraft');
        $response->assertSee('LEVEL UP YOUR');
        $response->assertSee('LOGIN / JOIN');
    }

    public function test_guest_is_redirected_to_login_when_accessing_protected_classes(): void
    {
        $response = $this->get('/classes');
        $response->assertRedirect('/login');
        $response->assertSessionHas('warning', 'Eits! Login atau daftar akun dulu yuk untuk membuka akses Kelas & Lab Simulasi!');
    }

    public function test_student_can_login(): void
    {
        $response = $this->post('/login', [
            'login' => 'siswa_demo',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_quick_demo_login_works(): void
    {
        $response = $this->post('/login/demo');
        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_student_can_register_and_claims_50_xp(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Santoso',
            'username' => 'budisamp',
            'email' => 'budi@smp.sch.id',
            'grade_level' => 'Kelas 8',
            'avatar' => 'code-wizard',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        
        $user = User::where('username', 'budisamp')->first();
        $this->assertNotNull($user);
        $this->assertEquals(50, $user->xp);
        $this->assertEquals('code-wizard', $user->avatar);
    }

    public function test_authenticated_lab_module_completion_syncs_xp(): void
    {
        $user = User::first();
        $initialXp = $user->xp;

        $response = $this->actingAs($user)->postJson('/lab/complete', [
            'module_slug' => 'network-packet-simulator',
            'xp_reward' => 25,
            'metadata' => ['latency_ms' => 15],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'new_xp' => $initialXp + 25,
        ]);

        $user->refresh();
        $this->assertEquals($initialXp + 25, $user->xp);
    }
}
