<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // Portafolio (Sistemas)
            'sistemas.viewAny',
            'sistemas.view',
            'sistemas.create',
            'sistemas.update',
            'sistemas.delete',
            'sistemas.manage_tech',
            'sistemas.manage_infra',

            // Proyectos
            'proyectos.viewAny',
            'proyectos.view',
            'proyectos.create',
            'proyectos.update',
            'proyectos.delete',
            'proyectos.manage_members',

            // Trabajo (Tareas + Gantt)
            'tareas.viewAny',
            'tareas.view',
            'tareas.create',
            'tareas.update',
            'tareas.delete',
            'tareas.assign',
            'tareas.move_state',
            'tareas.plan_dates',

            // Worklogs
            'worklogs.create',
            'worklogs.view',
            'worklogs.viewAny',
            'worklogs.update',
            'worklogs.delete',

            // Docs (Plantillas, Manuales, Versiones)
            'docs.viewAny',
            'docs.view',
            'docs.create',
            'docs.update',
            'docs.delete',
            'docs.publish',
            'plantillas.manage',

            // Reuniones / Acuerdos / Recordatorios
            'reuniones.viewAny',
            'reuniones.view',
            'reuniones.create',
            'reuniones.update',
            'reuniones.delete',
            'acuerdos.create',
            'acuerdos.update',
            'acuerdos.delete',
            'recordatorios.create',
            'recordatorios.update',
            'recordatorios.delete',

            // Contactos
            'contactos.viewAny',
            'contactos.view',
            'contactos.create',
            'contactos.update',
            'contactos.delete',

            // Integraciones
            'github.manage',
            'github.view',
            'jasper.manage',
            'jasper.run',
            'jasper.view',
            'ia.use',
            'ia.view',

            // Reportes / Auditoría
            'reportes.view',
            'kpis.view',
            'auditoria.view',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(
                ['name' => $permiso],
                ['guard_name' => 'web']
            );
        }
    }
}
