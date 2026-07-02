# DRS - Analisis ejecutivo del sistema

## 1. Proposito del documento

Este documento consolida el analisis funcional y tecnico del sistema ya construido, para usarlo como base de un DRS (Documento de Requerimientos del Software) formal, con enfoque institucional.

## 2. Contexto y alcance actual

La solucion implementada corresponde a una plataforma de gestion de desarrollos de software con arquitectura web sobre Laravel 11, orientada a:

- Gestion de portafolio y sistemas.
- Gestion de proyectos y miembros por rol.
- Gestion integral de tareas (ciclo operativo tipo Kanban).
- Gestion documental con versionado y publicacion.
- Gestion de reuniones, minutas y acuerdos convertibles a tareas.
- Registro de tiempos (worklogs).
- Reportes operativos iniciales.
- Control de acceso granular con RBAC (Spatie Permission + Policies).

## 3. Stack y arquitectura base

- **Backend:** Laravel 11, PHP 8.2+, Eloquent ORM.
- **Base de datos:** MySQL 8.
- **Autenticacion/UI base:** Laravel Breeze (Blade + Tailwind).
- **Autorizacion:** Spatie Laravel Permission + Policies por recurso.
- **Procesos asincronos:** Jobs + Scheduler nativo de Laravel.
- **Integraciones modeladas:** GitHub, Google Calendar, Google Drive, Correo (estructura de datos y modelos; conectores productivos sujetos a configuracion institucional).

## 4. Dominios funcionales construidos

Modulos con rutas y controladores activos (referencia: `routes/web.php`):

1. `sistemas`
2. `proyectos` (incluye gestion de miembros)
3. `tareas` (incluye `kanban`, `moveState`, `assign`, `planDates`)
4. `plantillas-documento`
5. `documentos` (incluye `createFromTemplate`, `addVersion`, `publish`, `showVersion`)
6. `reuniones` (incluye calendario)
7. `acuerdos` (incluye `toTask`)
8. `worklogs` (incluye vista semanal)
9. `comentarios` (polimorfico)
10. `reportes` (carga por dev, acuerdos vencidos, mi gantt, gantt por proyecto)

## 5. Seguridad y gobierno de acceso

El sistema implementa un esquema de seguridad orientado a gobierno de datos:

- Roles globales: `superadmin`, `pm`, `dev`, `qa`, `soporte`, `consulta`.
- Rol contextual por proyecto en pivote `proyecto_miembros.rol_en_proyecto`.
- Mapeo de policies registrado en `app/Providers/AuthServiceProvider.php`.
- `Gate::before` para acceso total de `superadmin`.
- Ocultamiento de acciones en vistas por `@can`.
- Validaciones de alcance por membresia de proyecto y reglas por rol operativo.

Detalle de permisos: ver `PERMISOS_COMPLETOS.md` y `RESUMEN_PERMISOS_ROLES.md`.

## 6. Modelo de informacion (estado)

Se construyo un modelo relacional amplio para MVP + V2 con:

- Entidades nucleares: sistemas, proyectos, tareas, documentos, reuniones, acuerdos, worklogs.
- Infraestructura asociada: ambientes, servidores, servicios, tecnologias.
- Colaboracion: comentarios, checklists, favoritos (polimorficas).
- Integraciones: tablas `github_*`, `google_calendar_integrations`, `google_drive_integrations`, `email_*`.
- Reporteria y analitica: `reportes_jasper`, `reportes_ejecuciones`.
- IA: `ia_prompts`, `ia_generaciones`.

Resumen de relaciones Eloquent: `RELACIONES_ELOQUENT.md`.

## 7. Reglas de negocio ya aplicadas

Reglas identificadas en codigo y documentacion operativa:

- Un proyecto no puede quedar sin PM activo.
- Fechas coherentes en proyecto/tarea (`fecha_fin >= fecha_inicio`).
- Restricciones de transicion de estados de tarea por rol (Form Requests + Policies).
- Registro de worklogs limitado al alcance autorizado.
- Publicacion documental sujeta a permisos y flujo de versionado.
- Seteo automatico de `created_by` y `updated_by` por observers.

## 8. Operacion y automatizacion

Componentes de operacion presentes:

- Seeders de roles/permisos y datos demo (`database/seeders/`).
- Jobs para recordatorios y procesamiento de webhooks (`app/Jobs/`).
- Scheduler en `routes/console.php` (recordatorios cada 5 minutos; webhooks cada minuto).
- Rutas de reportes operativos para seguimiento de carga y compromisos.

Guia operativa: `README_OPERATIVO.md`.

## 9. Nivel de madurez del sistema (para planificacion DRS)

- **Backend y reglas de negocio:** alto.
- **Seguridad y trazabilidad:** alto / medio-alto (depende de auditoria formal deseada).
- **UI operativa transversal:** medio (vistas amplias; validar UAT por perfil).
- **Integraciones externas productivas:** medio-bajo (estructura lista; falta hardening por conector/API real y politicas de secretos).
- **Operacion DevOps y monitoreo formal:** medio (scheduler/queues documentados; falta SLO/alertas si se exige en DRS).

## 10. Conclusion ejecutiva

La base construida es suficiente para redactar un DRS institucional completo sin partir de cero. El documento debe enfocarse en:

1. Formalizar alcance por modulo y por rol.
2. Cerrar criterios de aceptacion medibles por flujo.
3. Definir NFR (seguridad, rendimiento, auditoria, continuidad).
4. Establecer plan de validacion (UAT por perfil: PM, Dev, QA, Soporte, Consulta).
