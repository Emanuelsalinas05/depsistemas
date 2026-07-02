<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AsignarPermisosRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin - Todos los permisos
        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        // PM - Project Manager
        $pm = Role::findByName('pm');
        $pm->givePermissionTo([
            // Sistemas
            'sistemas.viewAny',
            'sistemas.view',
            'sistemas.update',
            'sistemas.manage_tech',
            'sistemas.manage_infra',
            
            // Proyectos
            'proyectos.viewAny',
            'proyectos.view',
            'proyectos.create',
            'proyectos.update',
            'proyectos.manage_members',
            
            // Tareas
            'tareas.viewAny',
            'tareas.view',
            'tareas.create',
            'tareas.update',
            'tareas.assign',
            'tareas.move_state',
            'tareas.plan_dates',
            
            // Worklogs
            'worklogs.viewAny',
            
            // Docs
            'docs.viewAny',
            'docs.view',
            'docs.create',
            'docs.update',
            'docs.publish',
            
            // Reuniones/Acuerdos
            'reuniones.viewAny',
            'reuniones.create',
            'reuniones.update',
            'acuerdos.create',
            'acuerdos.update',
            
            // Reportes
            'reportes.view',
            'kpis.view',
            
            // Integraciones
            'github.view',
            'jasper.run',
            'ia.use',
        ]);

        // Dev - Desarrollador
        $dev = Role::findByName('dev');
        $dev->givePermissionTo([
            // Sistemas/Proyectos (solo view donde es miembro)
            'sistemas.view',
            'proyectos.view',
            
            // Tareas
            'tareas.view',
            'tareas.create',
            'tareas.update',
            'tareas.move_state',
            
            // Worklogs
            'worklogs.create',
            'worklogs.view',
            'worklogs.update',
            
            // Docs (borradores)
            'docs.view',
            'docs.create',
            'docs.update',
            
            // Reuniones (si es asistente)
            'reuniones.view',
            
            // Acuerdos (si es responsable)
            'acuerdos.update',
            
            // IA
            'ia.use',
        ]);

        // QA
        $qa = Role::findByName('qa');
        $qa->givePermissionTo([
            // Sistemas/Proyectos (en proyectos asignados)
            'sistemas.view',
            'proyectos.view',
            
            // Tareas
            'tareas.view',
            'tareas.create', // bugs
            'tareas.update',
            'tareas.move_state', // hacia en_revision/listo_release
            
            // Docs
            'docs.view',
            
            // Reportes
            'reportes.view',
        ]);

        // Soporte
        $soporte = Role::findByName('soporte');
        $soporte->givePermissionTo([
            // Sistemas
            'sistemas.viewAny',
            'sistemas.view',
            
            // Proyectos
            'proyectos.view',
            
            // Tareas (tipo soporte/bug)
            'tareas.view',
            'tareas.create',
            'tareas.update',
            'tareas.move_state',
            
            // Contactos
            'contactos.viewAny',
            'contactos.view',
            'contactos.create',
            'contactos.update',
            
            // Auditoría (limitado)
            'auditoria.view',
        ]);

        // Consulta - Solo lectura
        $consulta = Role::findByName('consulta');
        $consulta->givePermissionTo([
            'sistemas.view',
            'proyectos.view',
            'tareas.view',
            'docs.view', // solo publicados
            'reuniones.view',
            'reportes.view',
        ]);
    }
}
