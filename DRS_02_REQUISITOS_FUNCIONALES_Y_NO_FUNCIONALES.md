# DRS - Requisitos funcionales y no funcionales (derivados del codigo)

## 1. Introduccion

Este documento traduce el sistema ya implementado en requisitos redactables para un DRS. Los identificadores RF-xxx / RNF-xxx son sugeridos para trazabilidad en matriz de pruebas.

## 2. Actores y roles

### 2.1 Roles globales (Spatie)

- **superadmin:** gobierno total del sistema.
- **pm:** administracion de proyectos y priorizacion dentro de su alcance.
- **dev:** ejecucion de trabajo asignado y registro de tiempos.
- **qa:** validacion y control de calidad con restricciones de transicion de estado.
- **soporte:** atencion de incidencias con alcance acotado.
- **consulta:** lectura segun permisos y contenido publicado donde aplique.

### 2.2 Rol por proyecto

Campo `proyecto_miembros.rol_en_proyecto` con valores: `pm`, `dev`, `qa`, `soporte`, `consulta`.

## 3. Requisitos funcionales por modulo

### 3.1 Autenticacion y perfil

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-AUTH-01 | El usuario debe autenticarse para acceder a modulos operativos. | Rutas MVP bajo `middleware(['auth', 'verified'])` en `routes/web.php`. |
| RF-AUTH-02 | El usuario puede gestionar su perfil (editar/actualizar/eliminar cuenta segun Breeze). | `routes/web.php` + `ProfileController`. |

### 3.2 Sistemas (portafolio)

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-SIS-01 | CRUD de sistemas con listado paginado y busqueda por `q`. | `SistemaController`, vistas en `resources/views/sistemas/`. |
| RF-SIS-02 | Acciones condicionadas por permisos `sistemas.*`. | `SistemaPolicy`, `PERMISOS_COMPLETOS.md`. |

### 3.3 Proyectos

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-PROY-01 | CRUD de proyectos con alcance por membresia. | `ProyectoController`. |
| RF-PROY-02 | Gestion de miembros del proyecto con roles en pivote. | Rutas `proyectos.members`, `proyectos.update-members`. |
| RF-PROY-03 | Un proyecto no puede quedar sin al menos un PM activo. | `ProyectoController`, `UpdateProyectoMembersRequest`, modelo `Proyecto`. |
| RF-PROY-04 | Coherencia de fechas de proyecto. | Validaciones en modelo/request. |

### 3.4 Tareas

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-TAR-01 | CRUD de tareas con filtros y busqueda. | `TareaController`, vistas `tareas/`. |
| RF-TAR-02 | Tablero Kanban por proyecto con persistencia de estado. | Ruta `tareas.kanban`, accion `moveState`. |
| RF-TAR-03 | Asignacion de responsable y planificacion de fechas como acciones finas. | `assign`, `planDates`. |
| RF-TAR-04 | Transiciones de estado sujetas a rol (QA, soporte, dev, PM). | `MoveTareaStateRequest` + `TareaPolicy`. |
| RF-TAR-05 | Coherencia fecha inicio/fin y progreso 0-100. | Modelo `Tarea`. |

### 3.5 Documentos y plantillas

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-DOC-01 | CRUD de plantillas de documento. | `PlantillaDocumentoController`. |
| RF-DOC-02 | CRUD de documentos con versionado. | `DocumentoController`, rutas `add-version`, `show-version`. |
| RF-DOC-03 | Creacion desde plantilla con prellenado. | `createFromTemplate`. |
| RF-DOC-04 | Publicacion formal del documento bajo permiso `docs.publish` y reglas asociadas. | `publish`, `DocumentoPolicy`. |

### 3.6 Reuniones, minutas y acuerdos

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-REU-01 | CRUD de reuniones con asistentes internos/externos. | `ReunionController`, vistas `reuniones/`. |
| RF-REU-02 | Vista de calendario de reuniones. | Ruta `reuniones.calendar`. |
| RF-ACU-01 | CRUD de acuerdos. | `AcuerdoController`. |
| RF-ACU-02 | Conversion de acuerdo a tarea dentro del proyecto relacionado. | `acuerdos.to-task`. |

### 3.7 Worklogs

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-WL-01 | Registro de tiempo asociado a tarea con validacion de minutos. | `WorklogController`, requests. |
| RF-WL-02 | Vista semanal del usuario. | `worklogs.my-week`. |
| RF-WL-03 | Alcance: dev ve/edita lo propio; PM segun proyecto. | `WorklogPolicy` + filtrado en controlador. |

### 3.8 Comentarios (polimorfico)

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-COM-01 | Crear, actualizar y eliminar comentarios sobre modelos permitidos. | `ComentarioController`, `StoreComentarioRequest`. |
| RF-COM-02 | Comentarios privados restringidos a perfiles autorizados. | Regla en request/policy segun implementacion. |

### 3.9 Reportes operativos

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-REP-01 | Indice de reportes. | `reportes.index`. |
| RF-REP-02 | Carga por desarrollador. | `reportes.carga-por-dev`. |
| RF-REP-03 | Acuerdos vencidos por proyecto. | `reportes.acuerdos-vencidos`. |
| RF-REP-04 | Gantt personal y por proyecto. | `reportes.mi-gantt`, `reportes.gantt-proyecto`. |

### 3.10 Integraciones (estructura)

| ID | Requisito | Evidencia / notas |
|----|-----------|-------------------|
| RF-INT-01 | Modelar integraciones GitHub (instalaciones, repos, eventos). | Migraciones `github_*`, policies `GithubPolicy`. |
| RF-INT-02 | Modelar Google Calendar / Google Drive / correo para sincronizacion y notificaciones. | Migraciones `google_*`, `email_*`, modelos asociados. |

Nota DRS: los RF de integracion deben completarse con flujos OAuth, rotacion de tokens, y matriz de datos sincronizados cuando se formalice el conector.

## 4. Requisitos no funcionales (NFR)

### 4.1 Seguridad

| ID | Requisito | Estado / evidencia |
|----|-----------|-------------------|
| RNF-SEG-01 | Autorizacion centralizada con Policies y permisos granulares. | `AuthServiceProvider`, `app/Policies/`. |
| RNF-SEG-02 | Separacion de privilegios entre rol global y rol en proyecto. | Pivote `proyecto_miembros`. |
| RNF-SEG-03 | Superadmin con bypass controlado (`Gate::before`). | `AuthServiceProvider`. |
| RNF-SEG-04 | Proteccion de rutas sensibles con `auth` y `verified`. | `routes/web.php`. |

### 4.2 Integridad de datos

| ID | Requisito | Estado / evidencia |
|----|-----------|-------------------|
| RNF-DAT-01 | Validaciones de consistencia temporal en entidades clave. | Modelos `Proyecto`, `Tarea`. |
| RNF-DAT-02 | Transacciones en operaciones multi-tabla (miembros, publicacion, conversion acuerdo-tarea). | Controladores indicados en `RESUMEN_COMPLETADO.md`. |

### 4.3 Auditoria y trazabilidad

| ID | Requisito | Estado / evidencia |
|----|-----------|-------------------|
| RNF-AUD-01 | Campos `created_by` / `updated_by` con observers. | `AppServiceProvider`, `ModelObserver`. |
| RNF-AUD-02 | Modelo/trait de actividad para extension de auditoria. | `ActivityLog`, `LogsActivity` (evaluar cobertura vs requerimiento institucional). |

### 4.4 Disponibilidad operativa (jobs y scheduler)

| ID | Requisito | Estado / evidencia |
|----|-----------|-------------------|
| RNF-OPS-01 | Ejecucion programada de recordatorios. | `routes/console.php`, `EnviarRecordatoriosJob`. |
| RNF-OPS-02 | Procesamiento asincrono de webhooks GitHub. | `ProcesarWebhookJob`. |
| RNF-OPS-03 | Colas configurables (`database` o `redis`). | `README_OPERATIVO.md`, `config/queue.php`. |

### 4.5 Usabilidad e interfaz

| ID | Requisito | Estado / evidencia |
|----|-----------|-------------------|
| RNF-UI-01 | Interfaz responsive con Tailwind y componentes reutilizables. | `resources/views/components/`, layouts. |
| RNF-UI-02 | Acciones visibles solo con permiso. | `@can` en navegacion y vistas. |

### 4.6 Mantenibilidad

| ID | Requisito | Estado / evidencia |
|----|-----------|-------------------|
| RNF-MNT-01 | Separacion por capas: Requests, Policies, Controllers. | Estructura `app/Http/Requests`, `app/Policies`. |
| RNF-MNT-02 | Semillas y factories para entornos de prueba. | `database/seeders/`, `database/factories/`. |

## 5. Matriz sugerida DRS -> prueba

Para cada RF, definir en el DRS oficial:

- Caso de prueba.
- Datos de prueba (roles).
- Resultado esperado (HTTP, mensaje flash, estado en BD).
- Evidencia (captura o log).

## 6. Referencias internas del repositorio

- Rutas: `routes/web.php`, `routes/auth.php`
- Permisos listados: `PERMISOS_COMPLETOS.md`
- Relaciones: `RELACIONES_ELOQUENT.md`
- Operacion: `README_OPERATIVO.md`
- Estado componentes: `RESUMEN_COMPLETADO.md` (validar secciones marcadas como pendientes frente al codigo actual)
