    # Sistema de Permisos Granulares - Lista Completa

## A) LISTA COMPLETA DE PERMISOS POR MÓDULO

### Portafolio (Sistemas)
- `sistemas.viewAny` - Ver listado de sistemas
- `sistemas.view` - Ver detalle de sistema
- `sistemas.create` - Crear sistema
- `sistemas.update` - Actualizar sistema
- `sistemas.delete` - Eliminar sistema
- `sistemas.manage_tech` - Gestionar tecnologías del sistema
- `sistemas.manage_infra` - Gestionar infraestructura (ambientes/servidores/servicios)
- `sistemas.archive` - Archivar sistema
- `sistemas.restore` - Restaurar sistema archivado

### Proyectos
- `proyectos.viewAny` - Ver listado de proyectos
- `proyectos.view` - Ver detalle de proyecto
- `proyectos.create` - Crear proyecto
- `proyectos.update` - Actualizar proyecto
- `proyectos.delete` - Eliminar proyecto
- `proyectos.manage_members` - Gestionar miembros del proyecto
- `proyectos.archive` - Archivar proyecto
- `proyectos.restore` - Restaurar proyecto

### Trabajo (Tareas)
- `tareas.viewAny` - Ver listado de tareas
- `tareas.view` - Ver detalle de tarea
- `tareas.create` - Crear tarea
- `tareas.update` - Actualizar tarea
- `tareas.delete` - Eliminar tarea
- `tareas.assign` - Asignar responsable
- `tareas.move_state` - Mover estado (Kanban)
- `tareas.plan_dates` - Planear fechas (inicio/fin/dependencias)
- `tareas.reopen` - Reabrir tarea cerrada
- `tareas.export` - Exportar tareas

### Worklogs
- `worklogs.create` - Crear registro de tiempo
- `worklogs.view` - Ver registro de tiempo
- `worklogs.viewAny` - Ver todos los registros
- `worklogs.update` - Actualizar registro
- `worklogs.delete` - Eliminar registro
- `worklogs.export` - Exportar worklogs

### Documentos
- `docs.viewAny` - Ver listado de documentos
- `docs.view` - Ver documento
- `docs.create` - Crear documento
- `docs.update` - Actualizar documento
- `docs.delete` - Eliminar documento
- `docs.publish` - Publicar documento
- `docs.archive` - Archivar documento
- `docs.restore` - Restaurar documento
- `docs.export` - Exportar documento

### Versiones de Documentos
- `docs.add_version` - Agregar versión
- `docs.view_versions` - Ver versiones
- `docs.delete_version` - Eliminar versión

### Plantillas
- `plantillas.manage` - Gestionar plantillas (crear/editar/eliminar)
- `plantillas.view` - Ver plantillas

### Releases
- `releases.viewAny` - Ver listado de releases
- `releases.view` - Ver detalle de release
- `releases.create` - Crear release
- `releases.update` - Actualizar release
- `releases.delete` - Eliminar release
- `releases.deploy_prod` - Desplegar a producción
- `releases.deploy_qa` - Desplegar a QA
- `releases.approve` - Aprobar release
- `releases.rollback` - Hacer rollback

### Reuniones
- `reuniones.viewAny` - Ver listado de reuniones
- `reuniones.view` - Ver detalle de reunión
- `reuniones.create` - Crear reunión
- `reuniones.update` - Actualizar reunión
- `reuniones.delete` - Eliminar reunión
- `reuniones.manage_attendees` - Gestionar asistentes

### Minutas
- `minutas.create` - Crear minuta
- `minutas.update` - Actualizar minuta
- `minutas.delete` - Eliminar minuta
- `minutas.view` - Ver minuta

### Acuerdos
- `acuerdos.viewAny` - Ver listado de acuerdos
- `acuerdos.view` - Ver detalle de acuerdo
- `acuerdos.create` - Crear acuerdo
- `acuerdos.update` - Actualizar acuerdo
- `acuerdos.delete` - Eliminar acuerdo
- `acuerdos.mark_completed` - Marcar como cumplido

### Contactos
- `contactos.viewAny` - Ver listado de contactos
- `contactos.view` - Ver detalle de contacto
- `contactos.create` - Crear contacto
- `contactos.update` - Actualizar contacto
- `contactos.delete` - Eliminar contacto
- `contactos.manage_interactions` - Gestionar interacciones

### Recordatorios
- `recordatorios.create` - Crear recordatorio
- `recordatorios.update` - Actualizar recordatorio
- `recordatorios.delete` - Eliminar recordatorio
- `recordatorios.view` - Ver recordatorios

### Bitácoras
- `bitacoras.create` - Crear bitácora
- `bitacoras.view` - Ver bitácoras
- `bitacoras.update` - Actualizar bitácora
- `bitacoras.view_team` - Ver bitácoras del equipo

### Checklists
- `checklists.create` - Crear checklist
- `checklists.update` - Actualizar checklist
- `checklists.delete` - Eliminar checklist
- `checklists.complete_item` - Completar item

### Comentarios
- `comentarios.create` - Crear comentario
- `comentarios.update` - Actualizar comentario (propio)
- `comentarios.delete` - Eliminar comentario (propio o si es admin)
- `comentarios.view` - Ver comentarios

### Etiquetas
- `etiquetas.create` - Crear etiqueta
- `etiquetas.update` - Actualizar etiqueta
- `etiquetas.delete` - Eliminar etiqueta
- `etiquetas.view` - Ver etiquetas

### Favoritos
- `favoritos.create` - Marcar como favorito
- `favoritos.delete` - Quitar favorito
- `favoritos.view` - Ver favoritos

### GitHub
- `github.manage` - Gestionar instalaciones/repositorios
- `github.view` - Ver repositorios
- `github.link_repo` - Vincular repositorio
- `github.unlink_repo` - Desvincular repositorio
- `github.view_webhooks` - Ver webhooks

### Jasper Reports
- `jasper.manage` - Gestionar plantillas de reportes
- `jasper.run` - Ejecutar reportes
- `jasper.view` - Ver reportes ejecutados
- `jasper.export` - Exportar reportes

### IA
- `ia.use` - Usar IA para generar contenido
- `ia.view` - Ver generaciones de IA
- `ia.manage_prompts` - Gestionar prompts de IA

### Reportes y Auditoría
- `reportes.view` - Ver reportes generales
- `kpis.view` - Ver KPIs
- `auditoria.view` - Ver auditoría
- `auditoria.export` - Exportar auditoría
