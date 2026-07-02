<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacRouteAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_guest_is_redirected_from_mvp_module(): void
    {
        $this->get('/sistemas')->assertRedirect(route('login'));
    }

    public function test_consulta_user_cannot_list_sistemas_without_view_any(): void
    {
        $user = User::factory()->create();
        $user->assignRole('consulta');

        $this->actingAs($user)
            ->get('/sistemas')
            ->assertForbidden();
    }

    public function test_superadmin_can_list_sistemas(): void
    {
        $user = User::factory()->create();
        $user->assignRole('superadmin');

        $this->actingAs($user)
            ->get('/sistemas')
            ->assertOk();
    }
}
