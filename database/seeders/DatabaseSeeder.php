<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        // Usuario inicial institucional (opcional; ver InitialAdminSeeder y README_PRODUCCION.md)
        $this->call(InitialAdminSeeder::class);

        // Datos demo SOLO en entornos no productivos y con opt-in explícito (SEED_DEMO_DATA=true)
        if ($this->shouldSeedDemoDataset()) {
            $this->call(DemoUserSeeder::class);
        }
    }

    /**
     * Nunca sembrar datos demo en producción, aunque SEED_DEMO_DATA esté mal configurado.
     */
    private function shouldSeedDemoDataset(): bool
    {
        if (app()->environment('production')) {
            return false;
        }

        return filter_var(env('SEED_DEMO_DATA', 'false'), FILTER_VALIDATE_BOOLEAN);
    }
}
