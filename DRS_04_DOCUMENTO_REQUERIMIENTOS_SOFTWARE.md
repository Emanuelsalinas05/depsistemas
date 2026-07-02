# Documento de Requerimientos de Software (DRS) - Base actual

## 1. Datos del documento
- **Proyecto:** Sistema de Gestion de Desarrollos
- **Version:** 1.0 (base actual)
- **Fecha:** 2026-04-22
- **Fuente:** estado real implementado en Laravel 11 + MySQL 8

## 2. Objetivo
Definir los requerimientos funcionales y no funcionales del sistema segun la implementacion actual para formalizar el DRS institucional y habilitar trazabilidad de pruebas.

## 3. Alcance del sistema
El sistema permite gestionar el ciclo operativo de desarrollo: portafolio, proyectos, tareas, documentacion, reuniones, acuerdos, worklogs, reportes e integraciones modeladas.

### 3.1 Modulos en alcance
- Sistemas
- Proyectos (incluye miembros)
- Tareas (kanban, mover estado, asignar, planificar fechas)
- Plantillas de documento
- Documentos (versionado, publicacion)
- Reuniones (agenda/calendario)
- Acuerdos (conversion a tarea)
- Worklogs
- Comentarios polimorficos
- Reportes operativos

## 4. Actores y roles
### 4.1 Roles globales
- `superadmin`
- `pm`
- `dev`
- `qa`
- `soporte`
- `consulta`

### 4.2 Rol por proyecto
- Campo: `proyecto_miembros.rol_en_proyecto`
- Valores: `pm`, `dev`, `qa`, `soporte`, `consulta`

## 5. Requisitos funcionales (RF)

### RF-AUTH (autenticacion)
- RF-AUTH-01: El usuario autenticado accede a modulos protegidos por `auth` y `verified`.
- RF-AUTH-02: El usuario puede gestionar perfil.

### RF-SIS (sistemas)
- RF-SIS-01: CRUD de sistemas con filtros y busqueda.
- RF-SIS-02: Gestion de tecnologias e infraestructura segun permisos.

### RF-PROY (proyectos)
- RF-PROY-01: CRUD de proyectos con alcance por membresia.
- RF-PROY-02: Gestion de miembros y rol por proyecto.
- RF-PROY-03: No permitir proyecto sin PM activo.

### RF-TAR (tareas)
- RF-TAR-01: CRUD de tareas con filtros.
- RF-TAR-02: Kanban por proyecto.
- RF-TAR-03: Acciones finas (`assign`, `move_state`, `plan_dates`).
- RF-TAR-04: Restricciones de transicion por rol.

### RF-DOC (documentos)
- RF-DOC-01: CRUD de plantillas y documentos.
- RF-DOC-02: Crear documento desde plantilla.
- RF-DOC-03: Agregar versiones y consultar historial.
- RF-DOC-04: Publicar documento con permisos de policy.

### RF-REU/ACU (reuniones/acuerdos)
- RF-REU-01: CRUD reuniones con asistentes.
- RF-REU-02: Vista calendario.
- RF-ACU-01: CRUD acuerdos.
- RF-ACU-02: Convertir acuerdo a tarea.

### RF-WL (worklogs)
- RF-WL-01: Registrar tiempo por tarea.
- RF-WL-02: Vista semanal de carga.
- RF-WL-03: Restriccion por alcance (propio/proyecto).

### RF-REP (reportes)
- RF-REP-01: Carga por desarrollador.
- RF-REP-02: Acuerdos vencidos.
- RF-REP-03: Mi gantt / gantt de proyecto.

## 6. Requisitos no funcionales (RNF)
- RNF-SEG-01: RBAC granular con Spatie + Policies.
- RNF-SEG-02: Gate de superadmin.
- RNF-DAT-01: Integridad de fechas y reglas de negocio.
- RNF-OPS-01: Jobs + Scheduler operativos.
- RNF-OPS-02: Soporte de colas (`database`/`redis`).
- RNF-AUD-01: `created_by`/`updated_by` por observers.
- RNF-UI-01: Interfaz responsiva con Blade + Tailwind.

## 7. Reglas de negocio clave
- Proyecto no puede quedar sin PM activo.
- Fechas coherentes en proyecto y tarea.
- Publicacion de documento solo por rol autorizado.
- Worklog solo dentro de alcance autorizado.
- Transiciones de estado de tarea restringidas por rol.

## 8. Criterios de aceptacion (resumen)
- Cada modulo debe cumplir CRUD + policy + validacion.
- Cada accion fina debe estar protegida y auditable.
- Los listados deben soportar filtros y `q`.
- El flujo principal debe ejecutarse con perfiles PM, Dev, QA y Soporte.

## 9. Trazabilidad sugerida
- RF -> ruta/controlador/request/policy
- RF -> caso de prueba (feature test)
- RF -> evidencia UAT

## 10. Referencias del repositorio
- `DRS_01_ANALISIS_EJECUTIVO.md`
- `DRS_02_REQUISITOS_FUNCIONALES_Y_NO_FUNCIONALES.md`
- `DRS_03_BRECHAS_Y_PLAN_DE_CIERRE.md`
- `PERMISOS_COMPLETOS.md`
- `RELACIONES_ELOQUENT.md`
- `ESTADO_MIGRACIONES_SEEDERS.md`
