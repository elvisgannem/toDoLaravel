<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_get_dashboard()
    {
        $admin = User::factory()->create(['isAdmin' => true]);
        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertOk();
    }

    public function test_normal_user_can_not_get_dashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertUnauthorized();
    }

    public function test_can_promote_user_to_admin()
    {
        $admin = User::factory()->create(['isAdmin' => true]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->put("/dashboard/make-admin/{$user->id}");

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'isAdmin' => true,
        ]);
    }

    public function test_admin_can_delete_an_user()
    {
        $admin = User::factory()->create(['isAdmin' => true]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->delete("/dashboard/delete-user/{$user->id}");

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_user_can_not_delete_another_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $response = $this->actingAs($user1)->delete("/dashboard/delete-user/{$user2->id}");

        $response->assertUnauthorized();

        $this->assertDatabaseHas('users', [
            'id' => $user2->id,
        ]);
    }
}
