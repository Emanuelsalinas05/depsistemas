<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'superadmin' => 'Super Administrador - Ve y hace todo',
            'pm' => 'Project Manager - Administra proyectos y prioriza',
            'dev' => 'Desarrollador - Ejecuta trabajo, tareas, worklogs',
            'qa' => 'QA - Valida y regresa hallazgos',
            'soporte' => 'Soporte - Atiende incidencias y tickets',
            'consulta' => 'Consulta - Solo lectura',
        ];

        foreach ($roles as $name => $description) {
            Role::firstOrCreate(
                ['name' => $name],
                ['guard_name' => 'web']
            );
        }
    }
}
