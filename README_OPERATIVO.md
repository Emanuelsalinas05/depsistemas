# Sistema de Gestión de Desarrollos - Guía Operativa

## 🚀 Configuración Inicial

### 1. Instalación de Dependencias

```bash
composer install
npm install
```

### 2. Configuración del Entorno

```bash
cp .env.example .env
php artisan key:generate
```

Configurar en `.env`:
- `DB_CONNECTION=mysql`
- `DB_DATABASE=tu_base_de_datos`
- `QUEUE_CONNECTION=database` (o `redis` si tienes Redis)
- `MAIL_MAILER=smtp` (para recordatorios)

### 3. Migraciones y Seeders

```bash
php artisan migrate
php artisan db:seed
```

Esto creará **siempre** roles y permisos (`RolesAndPermissionsSeeder`) y ejecutará `InitialAdminSeeder` (solo crea usuario si definió `INITIAL_ADMIN_EMAIL` / `INITIAL_ADMIN_PASSWORD` en `.env`).

**Datos demo (usuarios @example.com y proyecto ficticio):** solo si `APP_ENV` **no** es `production` **y** `SEED_DEMO_DATA=true` en `.env`. En producción institucional debe quedar `SEED_DEMO_DATA=false` u omitida.

Guía de despliegue duro: `README_PRODUCCION.md`, checklist: `CHECKLIST_GO_NO_GO_PRODUCCION.md`.

### 4. Storage Link

```bash
php artisan storage:link
```

### 5. Cola de Trabajos (Jobs)

Si usas `QUEUE_CONNECTION=database`:

```bash
php artisan queue:work
```

O configurar supervisor/systemd para ejecutar automáticamente.

### 6. Scheduler (Cron)

Agregar a crontab:

```bash
* * * * * cd /ruta/a/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

O en Windows con Task Scheduler ejecutar cada minuto:
```
php artisan schedule:run
```

## 📋 Rutas Principales

### Autenticación
- `/login` - Inicio de sesión
- `/register` - Registro (si está habilitado)
- `/dashboard` - Panel principal

### Módulos MVP
- `/sistemas` - Gestión de sistemas
- `/proyectos` - Gestión de proyectos
- `/tareas` - Gestión de tareas
- `/proyectos/{proyecto}/kanban` - Tablero Kanban
- `/documentos` - Gestión de documentos
- `/reuniones` - Gestión de reuniones
- `/acuerdos` - Gestión de acuerdos
- `/worklogs` - Registro de tiempos

### Reportes
- `/reportes` - Índice de reportes
- `/reportes/carga-por-dev` - Carga de trabajo por desarrollador
- `/reportes/acuerdos-vencidos` - Acuerdos vencidos
- `/reportes/mi-gantt` - Mi Gantt personal
- `/proyectos/{proyecto}/gantt` - Gantt del proyecto

## 🔐 Roles y Permisos

### Roles Globales (Spatie)

1. **superadmin**: Acceso total al sistema
2. **pm**: Project Manager - Administra proyectos y prioriza
3. **dev**: Desarrollador - Ejecuta trabajo, registra tiempos
4. **qa**: QA Tester - Valida y regresa hallazgos
5. **soporte**: Soporte - Atiende incidencias
6. **consulta**: Solo lectura

### Roles en Proyecto (Pivote)

En `proyecto_miembros.rol_en_proyecto`:
- `pm` - Project Manager del proyecto
- `dev` - Desarrollador
- `qa` - QA Tester
- `soporte` - Soporte
- `consulta` - Solo lectura

## ✅ Validaciones de Integridad

### Proyectos
- ✅ Un proyecto **no puede quedar sin PM activo**
- ✅ Fechas coherentes: `fecha_fin >= fecha_inicio`
- ✅ No se puede eliminar si tiene tareas activas

### Tareas
- ✅ Fechas coherentes: `fecha_fin >= fecha_inicio`
- ✅ Progreso entre 0 y 100

### Worklogs
- ✅ Solo se pueden registrar en proyectos donde el usuario es miembro
- ✅ Minutos entre 1 y 1440 (24 horas)

### Documentos
- ✅ Para publicar, debe existir al menos 1 versión

## 🔄 Jobs y Scheduler

### Jobs Disponibles

1. **EnviarRecordatoriosJob**
   - Se ejecuta cada 5 minutos
   - Envía recordatorios pendientes

2. **ProcesarWebhookJob**
   - Procesa webhooks de GitHub pendientes
   - Se ejecuta cada minuto

### Comandos Artisan

```bash
# Enviar recordatorios manualmente
php artisan recordatorios:enviar

# Procesar scheduler manualmente
php artisan schedule:run
```

## 📊 Reportes Disponibles

### 1. Carga por Desarrollador
- Muestra tareas en curso por dev
- Horas trabajadas en rango de fechas
- Acceso: `/reportes/carga-por-dev`

### 2. Acuerdos Vencidos
- Lista acuerdos con fecha de compromiso vencida
- Filtrable por proyecto
- Acceso: `/reportes/acuerdos-vencidos`

### 3. Gantt Personal
- Tareas asignadas al usuario actual
- Acceso: `/reportes/mi-gantt`

### 4. Gantt por Proyecto
- Todas las tareas del proyecto con fechas
- Acceso: `/proyectos/{proyecto}/gantt`

## 🎯 Flujo de Trabajo Recomendado

### Para un Project Manager (PM)

1. **Crear Sistema** → `/sistemas/create`
2. **Crear Proyecto** → `/proyectos/create`
3. **Asignar Miembros** → `/proyectos/{proyecto}/members`
4. **Crear Tareas** → `/tareas/create`
5. **Planificar Fechas** → Usar `planDates` en tareas
6. **Asignar Tareas** → Usar `assign` en tareas
7. **Ver Kanban** → `/proyectos/{proyecto}/kanban`
8. **Publicar Documentos** → `/documentos/{documento}/publish`

### Para un Desarrollador (Dev)

1. **Ver Mis Tareas** → `/tareas` (filtradas automáticamente)
2. **Ver Kanban del Proyecto** → `/proyectos/{proyecto}/kanban`
3. **Mover Estados** → Drag & drop en Kanban o `moveState`
4. **Registrar Tiempos** → `/worklogs/create`
5. **Ver Mi Gantt** → `/reportes/mi-gantt`

### Para un QA Tester

1. **Ver Tareas de Proyecto** → `/tareas`
2. **Crear Bugs** → `/tareas/create` (tipo: bug)
3. **Mover a Revisión** → Solo estados: `en_revision`, `listo_release`
4. **Ver Documentos Publicados** → `/documentos`

## 🧪 Prueba de Flujo Completo

### Escenario: Usuario Dev

1. **Login**: usar un usuario **dev** real del entorno (si usa datos demo locales, solo tras `SEED_DEMO_DATA=true` en no-producción).
2. **Verificar Scope**:
   - Solo ve proyectos donde es miembro
   - Solo ve tareas de esos proyectos
3. **Editar Tarea**:
   - Solo puede editar tareas asignadas a él o creadas por él
4. **Registrar Worklog**:
   - Solo puede registrar en tareas de proyectos donde es miembro
5. **Publicar Documento**:
   - ❌ No puede publicar (solo PM/superadmin)

## 📝 Notas Importantes

### Policies y Autorización

- Todas las acciones están protegidas por Policies
- Superadmin tiene acceso total (Gate::before)
- Scope filtering automático según membresía en proyectos

### Auditoría

- Los cambios importantes se registran en logs
- Campos `created_by` y `updated_by` se setean automáticamente
- Usar Spatie ActivityLog para auditoría completa (opcional)

### Storage

- Archivos de documentos: `storage/app/documentos/`
- Asegurar permisos de escritura en `storage/`
- Configurar backup regular de `storage/`

## 🐛 Troubleshooting

### Error: "El proyecto debe tener al menos un PM activo"
- **Causa**: Intentaste eliminar/desactivar todos los PMs
- **Solución**: Mantén al menos un PM activo

### Error: "La fecha de fin no puede ser anterior a la fecha de inicio"
- **Causa**: Fechas incoherentes en tarea/proyecto
- **Solución**: Corregir fechas

### Jobs no se ejecutan
- Verificar `QUEUE_CONNECTION` en `.env`
- Ejecutar `php artisan queue:work`
- Verificar tabla `jobs` y `failed_jobs`

### Scheduler no funciona
- Verificar crontab/Task Scheduler
- Ejecutar manualmente: `php artisan schedule:run`
- Verificar logs en `storage/logs/`

## 📚 Próximos Pasos

1. ✅ Crear vistas Blade para todas las pantallas
2. ✅ Implementar Kanban con drag & drop (JavaScript)
3. ✅ Implementar Gantt con biblioteca (ej: Frappe Gantt)
4. ✅ Implementar Calendario con FullCalendar
5. ✅ Integrar Spatie ActivityLog para auditoría completa
6. ✅ Configurar notificaciones por email
7. ✅ Implementar búsqueda global avanzada (Scout + Meilisearch)
