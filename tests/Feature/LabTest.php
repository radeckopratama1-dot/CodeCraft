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
        $response->assertSee('Our Classes');
    }

    public function test_lab_module_completion_syncs_xp(): void
    {
        $user = User::first();
        $initialXp = $user->xp;

        $response = $this->postJson('/lab/complete', [
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
