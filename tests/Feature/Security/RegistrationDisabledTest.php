<?php

namespace Tests\Feature\Security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationDisabledTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_routes_return_404_when_disabled(): void
    {
        config(['app.disable_registration' => true]);

        $this->get('/register')->assertNotFound();
        $this->post('/register', [
            'name' => 'X',
            'email' => 'x@example.com',
            'password' => 'Password123!@#',
            'password_confirmation' => 'Password123!@#',
        ])->assertNotFound();
    }

    public function test_register_works_when_enabled_in_non_production_testing(): void
    {
        config(['app.disable_registration' => false]);

        $this->get('/register')->assertOk();
    }
}
