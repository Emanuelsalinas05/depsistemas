<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use App\Models\Sistema;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            throw new \RuntimeException(
                'DemoUserSeeder no puede ejecutarse en APP_ENV=production. Use InitialAdminSeeder y cuentas reales.'
            );
        }

        // Usuario Superadmin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->hasRole('superadmin')) {
            $admin->assignRole('superadmin');
        }

        // Usuario PM
        $pm = User::firstOrCreate(
            ['email' => 'pm@example.com'],
            [
                'name' => 'Project Manager',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        if (!$pm->hasRole('pm')) {
            $pm->assignRole('pm');
        }

        // Usuario Dev
        $dev = User::firstOrCreate(
            ['email' => 'dev@example.com'],
            [
                'name' => 'Desarrollador',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        if (!$dev->hasRole('dev')) {
            $dev->assignRole('dev');
        }

        // Usuario QA
        $qa = User::firstOrCreate(
            ['email' => 'qa@example.com'],
            [
                'name' => 'QA Tester',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
        if (!$qa->hasRole('qa')) {
            $qa->assignRole('qa');
        }

        // Crear sistema demo
        $sistema = Sistema::firstOrCreate(
            ['slug' => 'sistema-demo'],
            [
                'nombre' => 'Sistema Demo',
                'descripcion' => 'Sistema de demostración para pruebas',
                'criticidad' => 'alta',
                'estatus' => 'activo',
                'created_by' => $admin->id,
            ]
        );

        // Crear proyecto demo
        $proyecto = Proyecto::firstOrCreate(
            ['slug' => 'proyecto-demo'],
            [
                'sistema_id' => $sistema->id,
                'nombre' => 'Proyecto Demo',
                'objetivo' => 'Proyecto de demostración',
                'fecha_inicio' => now()->subDays(30),
                'fecha_fin' => now()->addDays(60),
                'estatus' => 'en_progreso',
                'created_by' => $pm->id,
            ]
        );

        // Asignar miembros al proyecto
        $proyecto->miembros()->syncWithoutDetaching([
            $pm->id => ['rol_en_proyecto' => 'pm', 'asignacion_activa' => true],
            $dev->id => ['rol_en_proyecto' => 'dev', 'asignacion_activa' => true],
            $qa->id => ['rol_en_proyecto' => 'qa', 'asignacion_activa' => true],
        ]);

        // Crear tareas demo
        $tareas = [
            [
                'titulo' => 'Configurar entorno de desarrollo',
                'tipo' => 'feature',
                'prioridad' => 'alta',
                'estado' => 'en_curso',
                'asignado_a' => $dev->id,
                'fecha_inicio' => now()->subDays(5),
                'fecha_fin' => now()->addDays(5),
                'estimacion_horas' => 8,
                'progreso' => 60,
            ],
            [
                'titulo' => 'Implementar autenticación',
                'tipo' => 'feature',
                'prioridad' => 'alta',
                'estado' => 'nuevo',
                'asignado_a' => $dev->id,
                'fecha_inicio' => now()->addDays(6),
                'fecha_fin' => now()->addDays(15),
                'estimacion_horas' => 16,
                'progreso' => 0,
            ],
            [
                'titulo' => 'Bug: Error en login',
                'tipo' => 'bug',
                'prioridad' => 'alta',
                'estado' => 'en_revision',
                'asignado_a' => $qa->id,
                'fecha_inicio' => now()->subDays(2),
                'fecha_fin' => now()->addDays(1),
                'estimacion_horas' => 4,
                'progreso' => 100,
            ],
            [
                'titulo' => 'Documentar API',
                'tipo' => 'doc',
                'prioridad' => 'media',
                'estado' => 'nuevo',
                'asignado_a' => $dev->id,
                'fecha_inicio' => now()->addDays(20),
                'fecha_fin' => now()->addDays(25),
                'estimacion_horas' => 8,
                'progreso' => 0,
            ],
            [
                'titulo' => 'Mejora: Optimizar consultas',
                'tipo' => 'mejora',
                'prioridad' => 'baja',
                'estado' => 'nuevo',
                'asignado_a' => $dev->id,
                'fecha_inicio' => now()->addDays(30),
                'fecha_fin' => now()->addDays(40),
                'estimacion_horas' => 12,
                'progreso' => 0,
            ],
        ];

        foreach ($tareas as $tareaData) {
            Tarea::firstOrCreate(
                [
                    'proyecto_id' => $proyecto->id,
                    'titulo' => $tareaData['titulo'],
                ],
                array_merge($tareaData, [
                    'proyecto_id' => $proyecto->id,
                    'descripcion' => 'Tarea de demostración',
                    'created_by' => $pm->id,
                ])
            );
        }

        if ($this->command) {
            $this->command->warn('DemoUserSeeder: datos de demostración creados. NO usar estas credenciales fuera de desarrollo.');
            $this->command->info('Sistema y proyecto demo creados con 5 tareas.');
        }
    }
}
