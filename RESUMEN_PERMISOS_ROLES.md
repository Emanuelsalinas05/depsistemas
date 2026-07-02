# Resumen: Roles vs Permisos Clave y Reglas de Scope

## Tabla: Roles vs Permisos Clave

| Permiso | superadmin | pm | dev | qa | soporte | consulta |
|---------|-----------|----|----|----|---------|----------|
| **Sistemas** |
| sistemas.viewAny | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ |
| sistemas.view | ✅ | ✅ | ✅* | ✅* | ✅ | ✅ |
| sistemas.update | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| sistemas.manage_tech | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| sistemas.manage_infra | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| **Proyectos** |
| proyectos.viewAny | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| proyectos.view | ✅ | ✅* | ✅* | ✅* | ✅* | ✅ |
| proyectos.create | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| proyectos.update | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| proyectos.manage_members | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| **Tareas** |
| tareas.viewAny | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| tareas.view | ✅ | ✅* | ✅* | ✅* | ✅* | ✅ |
| tareas.create | ✅ | ✅* | ✅* | ✅* | ✅** | ❌ |
| tareas.update | ✅ | ✅* | ✅*** | ✅* | ✅* | ❌ |
| tareas.assign | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| tareas.move_state | ✅ | ✅* | ✅* | ✅**** | ✅***** | ❌ |
| tareas.plan_dates | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| **Worklogs** |
| worklogs.create | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ |
| worklogs.view | ✅ | ✅* | ✅ | ❌ | ❌ | ❌ |
| worklogs.update | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ |
| **Documentos** |
| docs.view | ✅ | ✅* | ✅* | ✅* | ✅* | ✅****** |
| docs.create | ✅ | ✅* | ✅* | ❌ | ❌ | ❌ |
| docs.update | ✅ | ✅* | ✅*** | ❌ | ❌ | ❌ |
| docs.publish | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| **Releases** |
| releases.view | ✅ | ✅* | ✅* | ✅* | ❌ | ✅ |
| releases.create | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| releases.deploy_prod | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| releases.deploy_qa | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| **Reuniones** |
| reuniones.view | ✅ | ✅* | ✅* | ✅* | ❌ | ✅ |
| reuniones.create | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| reuniones.update | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| **Acuerdos** |
| acuerdos.view | ✅ | ✅* | ✅* | ✅* | ❌ | ❌ |
| acuerdos.create | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| acuerdos.update | ✅ | ✅* | ✅******* | ❌ | ❌ | ❌ |
| **Contactos** |
| contactos.viewAny | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ |
| contactos.create | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ |
| contactos.update | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ |
| **GitHub** |
| github.manage | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| github.view | ✅ | ✅* | ✅* | ❌ | ❌ | ❌ |
| github.link_repo | ✅ | ✅* | ❌ | ❌ | ❌ | ❌ |
| **Jasper** |
| jasper.manage | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| jasper.run | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ |
| jasper.view | ✅ | ✅ | ❌ | ❌ | ✅ | ❌ |
| **IA** |
| ia.use | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| ia.view | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| ia.manage_prompts | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **Reportes** |
| reportes.view | ✅ | ✅ | ❌ | ✅ | ❌ | ✅ |
| kpis.view | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| auditoria.view | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ |

**Leyenda:**
- ✅ = Tiene permiso
- ❌ = No tiene permiso
- ✅* = Solo en proyectos/sistemas donde es miembro
- ✅** = Solo tipo "soporte"
- ✅*** = Solo si es asignado o creador
- ✅**** = Solo hacia "en_revision" o "listo_release"
- ✅***** = Solo hasta "en_revision"
- ✅****** = Solo documentos publicados
- ✅******* = Solo si es responsable

## Reglas de Scope Más Importantes

### 1. Miembro de Proyecto
**Aplica a:** dev, qa, soporte
**Regla:** Solo puede acceder a recursos de proyectos donde es miembro activo (`proyecto_miembros.asignacion_activa = true`)

### 2. PM en Proyecto
**Aplica a:** pm
**Regla:** Puede gestionar recursos si `rol_en_proyecto = 'pm'` en el proyecto relacionado

### 3. Asignado a Mí
**Aplica a:** dev (tareas, acuerdos)
**Regla:** Puede actualizar si `asignado_a = user.id` o `responsable_id = user.id`

### 4. Creado por Mí
**Aplica a:** dev (documentos, comentarios)
**Regla:** Puede actualizar/eliminar si `created_by = user.id`

### 5. Documento Publicado
**Aplica a:** consulta
**Regla:** Solo puede ver documentos con `estado = 'publicado'`

### 6. Estados Permitidos (QA)
**Aplica a:** qa
**Regla:** Solo puede mover tareas a estados `en_revision` o `listo_release`

### 7. Estados Permitidos (Soporte)
**Aplica a:** soporte
**Regla:** Solo puede mover tareas hasta `en_revision` (no `listo_release` ni `cerrado`)

### 8. Tipo de Tarea (Soporte)
**Aplica a:** soporte
**Regla:** Solo puede crear tareas con `tipo = 'soporte'`

### 9. Infraestructura (Secretos)
**Aplica a:** Todos excepto superadmin
**Regla:** No puede ver ni editar `secret_ref` en servidores/servicios

### 10. Producción (Deploy)
**Aplica a:** pm, superadmin
**Regla:** Solo PM y superadmin pueden desplegar a producción

### 11. Publicación de Documentos
**Aplica a:** pm
**Regla:** Solo puede publicar documentos de sistemas donde es PM en algún proyecto

### 12. Asignación de Tareas
**Aplica a:** pm
**Regla:** Solo puede asignar tareas en proyectos donde es PM

### 13. Planificación de Fechas
**Aplica a:** pm
**Regla:** Solo puede planear fechas en proyectos donde es PM

### 14. Gestión de Miembros
**Aplica a:** pm
**Regla:** Solo puede gestionar miembros en proyectos donde es PM

### 15. Worklogs Propios
**Aplica a:** dev
**Regla:** Solo puede crear/actualizar/eliminar sus propios worklogs

### 16. Comentarios Propios
**Aplica a:** Todos
**Regla:** Solo puede actualizar/eliminar sus propios comentarios (excepto PM/superadmin que pueden eliminar cualquiera)

### 17. Acuerdos Responsable
**Aplica a:** dev
**Regla:** Puede actualizar acuerdos donde `responsable_id = user.id`

### 18. Reuniones Asistente
**Aplica a:** Todos
**Regla:** Puede ver reuniones donde es asistente o miembro del proyecto

### 19. GitHub Repositorios
**Aplica a:** dev, qa
**Regla:** Solo puede ver repositorios de sistemas/proyectos donde es miembro

### 20. IA Generaciones
**Aplica a:** Todos
**Regla:** Puede ver sus propias generaciones; PM/superadmin pueden ver todas
