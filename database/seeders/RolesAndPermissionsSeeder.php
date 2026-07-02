<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear todos los permisos
        $permisos = [
            // Portafolio (Sistemas)
            'sistemas.viewAny',
            'sistemas.view',
            'sistemas.create',
            'sistemas.update',
            'sistemas.delete',
            'sistemas.manage_tech',
            'sistemas.manage_infra',
            'sistemas.archive',
            'sistemas.restore',

            // Proyectos
            'proyectos.viewAny',
            'proyectos.view',
            'proyectos.create',
            'proyectos.update',
            'proyectos.delete',
            'proyectos.manage_members',
            'proyectos.archive',
            'proyectos.restore',

            // Trabajo (Tareas)
            'tareas.viewAny',
            'tareas.view',
            'tareas.create',
            'tareas.update',
            'tareas.delete',
            'tareas.assign',
            'tareas.move_state',
            'tareas.plan_dates',
            'tareas.reopen',
            'tareas.export',

            // Worklogs
            'worklogs.create',
            'worklogs.view',
            'worklogs.viewAny',
            'worklogs.update',
            'worklogs.delete',
            'worklogs.export',

            // Documentos
            'docs.viewAny',
            'docs.view',
            'docs.create',
            'docs.update',
            'docs.delete',
            'docs.publish',
            'docs.archive',
            'docs.restore',
            'docs.export',

            // Versiones de Documentos
            'docs.add_version',
            'docs.view_versions',
            'docs.delete_version',

            // Plantillas
            'plantillas.manage',
            'plantillas.view',

            // Releases
            'releases.viewAny',
            'releases.view',
            'releases.create',
            'releases.update',
            'releases.delete',
            'releases.deploy_prod',
            'releases.deploy_qa',
            'releases.approve',
            'releases.rollback',

            // Reuniones
            'reuniones.viewAny',
            'reuniones.view',
            'reuniones.create',
            'reuniones.update',
            'reuniones.delete',
            'reuniones.manage_attendees',

            // Minutas
            'minutas.create',
            'minutas.update',
            'minutas.delete',
            'minutas.view',

            // Acuerdos
            'acuerdos.viewAny',
            'acuerdos.view',
            'acuerdos.create',
            'acuerdos.update',
            'acuerdos.delete',
            'acuerdos.mark_completed',

            // Contactos
            'contactos.viewAny',
            'contactos.view',
            'contactos.create',
            'contactos.update',
            'contactos.delete',
            'contactos.manage_interactions',

            // Recordatorios
            'recordatorios.create',
            'recordatorios.update',
            'recordatorios.delete',
            'recordatorios.view',

            // Bitácoras
            'bitacoras.create',
            'bitacoras.view',
            'bitacoras.update',
            'bitacoras.view_team',

            // Checklists
            'checklists.create',
            'checklists.update',
            'checklists.delete',
            'checklists.complete_item',

            // Comentarios
            'comentarios.create',
            'comentarios.update',
            'comentarios.delete',
            'comentarios.view',

            // Etiquetas
            'etiquetas.create',
            'etiquetas.update',
            'etiquetas.delete',
            'etiquetas.view',

            // Favoritos
            'favoritos.create',
            'favoritos.delete',
            'favoritos.view',

            // GitHub
            'github.manage',
            'github.view',
            'github.link_repo',
            'github.unlink_repo',
            'github.view_webhooks',

            // Jasper Reports
            'jasper.manage',
            'jasper.run',
            'jasper.view',
            'jasper.export',

            // IA
            'ia.use',
            'ia.view',
            'ia.manage_prompts',

            // Reportes y Auditoría
            'reportes.view',
            'kpis.view',
            'auditoria.view',
            'auditoria.export',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(
                ['name' => $permiso],
                ['guard_name' => 'web']
            );
        }

        // Crear roles
        $roles = [
            'superadmin' => 'Super Administrador - Acceso total',
            'pm' => 'Project Manager - Administra proyectos',
            'dev' => 'Desarrollador - Ejecuta trabajo',
            'qa' => 'QA - Valida y reporta',
            'soporte' => 'Soporte - Atiende incidencias',
            'consulta' => 'Consulta - Solo lectura',
        ];

        foreach ($roles as $name => $description) {
            Role::firstOrCreate(
                ['name' => $name],
                ['guard_name' => 'web']
            );
        }

        // Asignar permisos a roles

        // SUPERADMIN - Todos los permisos
        $superadmin = Role::findByName('superadmin');
        $superadmin->givePermissionTo(Permission::all());

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
            'tareas.reopen',
            'tareas.export',
            
            // Worklogs
            'worklogs.viewAny',
            'worklogs.view',
            
            // Documentos
            'docs.viewAny',
            'docs.view',
            'docs.create',
            'docs.update',
            'docs.publish',
            'docs.add_version',
            'docs.view_versions',
            'docs.export',
            
            // Plantillas
            'plantillas.view',
            
            // Releases
            'releases.viewAny',
            'releases.view',
            'releases.create',
            'releases.update',
            'releases.deploy_qa',
            'releases.approve',
            
            // Reuniones
            'reuniones.viewAny',
            'reuniones.view',
            'reuniones.create',
            'reuniones.update',
            'reuniones.manage_attendees',
            
            // Minutas
            'minutas.create',
            'minutas.update',
            'minutas.view',
            
            // Acuerdos
            'acuerdos.viewAny',
            'acuerdos.view',
            'acuerdos.create',
            'acuerdos.update',
            'acuerdos.mark_completed',
            
            // Contactos
            'contactos.viewAny',
            'contactos.view',
            
            // Recordatorios
            'recordatorios.create',
            'recordatorios.update',
            'recordatorios.view',
            
            // Bitácoras
            'bitacoras.view_team',
            
            // Checklists
            'checklists.create',
            'checklists.update',
            'checklists.delete',
            'checklists.complete_item',
            
            // Comentarios
            'comentarios.create',
            'comentarios.update',
            'comentarios.view',
            
            // Etiquetas
            'etiquetas.create',
            'etiquetas.update',
            'etiquetas.view',
            
            // Favoritos
            'favoritos.create',
            'favoritos.delete',
            'favoritos.view',
            
            // GitHub
            'github.view',
            'github.link_repo',
            'github.view_webhooks',
            
            // Jasper
            'jasper.run',
            'jasper.view',
            
            // IA
            'ia.use',
            'ia.view',
            
            // Reportes
            'reportes.view',
            'kpis.view',
        ]);

        // DEV - Desarrollador
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
            
            // Documentos (borradores)
            'docs.view',
            'docs.create',
            'docs.update',
            'docs.add_version',
            'docs.view_versions',
            
            // Plantillas
            'plantillas.view',
            
            // Releases
            'releases.view',
            
            // Reuniones
            'reuniones.view',
            
            // Acuerdos (si es responsable)
            'acuerdos.view',
            'acuerdos.update',
            
            // Bitácoras
            'bitacoras.create',
            'bitacoras.view',
            'bitacoras.update',
            
            // Checklists
            'checklists.complete_item',
            
            // Comentarios
            'comentarios.create',
            'comentarios.update',
            'comentarios.view',
            
            // Etiquetas
            'etiquetas.view',
            
            // Favoritos
            'favoritos.create',
            'favoritos.delete',
            'favoritos.view',
            
            // GitHub
            'github.view',
            
            // IA
            'ia.use',
        ]);

        // QA
        $qa = Role::findByName('qa');
        $qa->givePermissionTo([
            // Sistemas/Proyectos
            'sistemas.view',
            'proyectos.view',
            
            // Tareas
            'tareas.view',
            'tareas.create', // bugs
            'tareas.update',
            'tareas.move_state', // hacia en_revision/listo_release
            
            // Documentos
            'docs.view',
            
            // Releases
            'releases.view',
            
            // Reuniones
            'reuniones.view',
            
            // Checklists
            'checklists.complete_item',
            
            // Comentarios
            'comentarios.create',
            'comentarios.view',
            
            // Etiquetas
            'etiquetas.view',
            
            // Reportes
            'reportes.view',
        ]);

        // SOPORTE
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
            'tareas.move_state', // hasta en_revision
            
            // Documentos
            'docs.view',
            
            // Contactos
            'contactos.viewAny',
            'contactos.view',
            'contactos.create',
            'contactos.update',
            'contactos.manage_interactions',
            
            // Bitácoras
            'bitacoras.view',
            
            // Comentarios
            'comentarios.create',
            'comentarios.view',
            
            // Jasper
            'jasper.run',
            'jasper.view',
            
            // Auditoría
            'auditoria.view',
        ]);

        // CONSULTA - Solo lectura
        $consulta = Role::findByName('consulta');
        $consulta->givePermissionTo([
            'sistemas.view',
            'proyectos.view',
            'tareas.view',
            'docs.view', // solo publicados
            'releases.view',
            'reuniones.view',
            'reportes.view',
        ]);
    }
}
