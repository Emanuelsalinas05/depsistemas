<?php

namespace Tests\Unit;

use Database\Seeders\DemoUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoUserSeederProductionGuardTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        if (isset($this->app)) {
            $this->app->detectEnvironment(fn () => 'testing');
        }

        parent::tearDown();
    }

    public function test_demo_user_seeder_throws_in_production_environment(): void
    {
        $this->app->detectEnvironment(fn () => 'production');

        $this->expectException(\RuntimeException::class);

        $this->seed(DemoUserSeeder::class);
    }
}
