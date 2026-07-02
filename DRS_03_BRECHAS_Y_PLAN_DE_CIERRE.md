# DRS - Brechas, riesgos y plan de cierre

## 1. Objetivo

Identificar lo que falta o requiere formalizacion para que el DRS quede cerrado bajo criterios institucionales (seguridad, continuidad, trazabilidad y aceptacion).

## 2. Coherencia documentacion vs codigo (actualizado)

**Estado tras auditoria de endurecimiento (produccion institucional):**

- Las rutas MVP viven en `routes/web.php` (grupo `auth` + `verified`). El archivo `routes/web_mvp.php` puede existir como referencia historica pero **no** es el cargador principal actual: priorizar `routes/web.php` en la documentacion operativa.
- `RESUMEN_COMPLETADO.md` fue alineado: las secciones que marcaban vistas/Kanban como “pendientes” quedaron **obsoletas** frente al arbol actual de `resources/views/`; usar `VISTAS_FINALES_COMPLETADAS.md` o revision directa del codigo para el estado de UI.
- Nueva documentacion de despliegue: `README_PRODUCCION.md`, `DEPLOY_PRODUCCION.md`, `CHECKLIST_GO_NO_GO_PRODUCCION.md`, `DIAGNOSTICO_PRODUCCION.md`, `docs/INTEGRACIONES_HARDENING.md`.

## 3. Brechas funcionales probables

| Area | Brecha | Impacto | Accion recomendada en DRS |
|------|--------|---------|---------------------------|
| Integraciones Google / correo | Modelo y tablas listas; falta flujo OAuth, refresh tokens, politicas de retencion y errores | Medio-Alto | RF de integracion + diagramas de secuencia + requisitos de secretos |
| GitHub webhooks | Job y scheduler presentes; validar firma, idempotencia, reintentos | Medio | NFR seguridad + pruebas de carga de eventos |
| Jasper / IA | Policies y tablas; falta flujo operativo institucional (quien ejecuta, donde corre Jasper) | Medio | Alcance V2 explicito o fuera de alcance MVP |
| Busqueda global | Busqueda `q` por listado; sin motor full-text | Bajo-Medio | Decidir Scout/Meilisearch o mantener busqueda simple |
| Dashboard | Ruta `/dashboard` devuelve vista generica; evaluar `DashboardController` vs closure | Bajo | RF de KPIs y fuentes de datos |

## 4. Brechas no funcionales

| Tema | Brecha | Accion DRS |
|------|--------|------------|
| Secretos | Tokens API en BD requieren cifrado y rotacion | RNF cifrado en reposo, gestion de llaves |
| Auditoria | Activity log parcial vs auditoria completa institucional | Definir eventos obligatorios y retencion |
| Backup/DR | No documentado en repo | RPO/RTO, backups MySQL y `storage/` |
| Observabilidad | Logs Laravel estandar | RNF monitoreo, alertas, correlacion de request-id |
| Rendimiento | Sin pruebas de carga documentadas | Objetivos por pantalla y consultas pesadas |

## 5. Riesgos

1. **Autorizacion compleja (rol global + rol en proyecto):** riesgo de regresiones si no hay pruebas automatizadas por matriz rol x accion.
2. **Integraciones externas:** riesgo de exposicion de credenciales sin estandar de vault.
3. **Colas y scheduler:** si no hay worker/cron institucional, los jobs quedan diferidos (recordatorios/webhooks).
4. **Datos demo en seeders:** riesgo de despliegue a produccion sin desactivar credenciales demo.

Mitigaciones sugeridas: tests de autorizacion, checklist de despliegue, variables de entorno por ambiente, politica de datos demo solo en dev/stage.

## 6. Plan de cierre del DRS (propuesta)

### Fase A - Congelar alcance

- Lista de modulos in-scope (MVP) vs V2.
- Lista de roles y permisos aprobados (baseline: `RolesAndPermissionsSeeder`).

### Fase B - Especificacion funcional

- Por cada modulo: actores, precondiciones, flujo principal, flujos alternos, reglas, mensajes.
- Criterios de aceptacion medibles (tabla RF -> prueba).

### Fase C - Especificacion no funcional

- Seguridad (authz, datos sensibles, sesiones, HTTPS).
- Operacion (queue, schedule, backups).
- Cumplimiento (retencion de logs, acceso a datos personales en contactos/reuniones).

### Fase D - Validacion

- UAT por rol con casos minimos:
  - PM: miembros, planificacion, publicacion doc.
  - Dev: tareas asignadas, worklogs, sin publicar.
  - QA: transiciones permitidas.
  - Soporte: tareas soporte y transiciones acotadas.
  - Consulta: solo lectura y documentos publicados.

### Fase E - Transicion

- Manual de operacion institucional (basado en `README_OPERATIVO.md`).
- Plan de capacitacion y soporte de primer nivel.

## 7. Entregables DRS minimos (checklist)

- [ ] Vision y alcance firmado
- [ ] Glosario (estados de tarea, tipos de documento, estatus de proyecto)
- [ ] Matriz rol-permiso aprobada
- [ ] Modelo de datos (DER) exportado desde MySQL o diagrama mantenido
- [ ] Lista RF/RNF con trazabilidad a pruebas
- [ ] Decisiones de integraciones (in/out) con responsables

## 8. Indice de archivos DRS generados

- `DRS_01_ANALISIS_EJECUTIVO.md` - contexto, dominios, madurez
- `DRS_02_REQUISITOS_FUNCIONALES_Y_NO_FUNCIONALES.md` - RF/RNF derivados del codigo
- `DRS_03_BRECHAS_Y_PLAN_DE_CIERRE.md` - riesgos, brechas, cierre

Documentacion complementaria existente: `README_OPERATIVO.md`, `PERMISOS_COMPLETOS.md`, `RELACIONES_ELOQUENT.md`, `RESUMEN_COMPLETADO.md`.

## 9. Cierre aplicado en codigo (produccion institucional)

| Tema | Accion realizada |
|------|------------------|
| Seeders demo | `DatabaseSeeder` ya **no** ejecuta `DemoUserSeeder` en `production`; demo solo con `SEED_DEMO_DATA=true` en entornos no productivos. `DemoUserSeeder` lanza excepcion si se fuerza en produccion. |
| Usuario inicial | Nuevo `InitialAdminSeeder` controlado por `INITIAL_ADMIN_*` (contrasena fuerte exigida en produccion). |
| Seguridad HTTP | Middleware `SecurityHeaders`, correlacion `X-Request-Id` (`AssignRequestId`), `TRUSTED_PROXIES`, `APP_FORCE_HTTPS` + HSTS opcional. |
| Autenticacion | `LOGIN_MAX_ATTEMPTS` configurable; `throttle` en POST `/login`; registro deshabilitado por defecto en `production`. |
| Webhooks GitHub (job) | Transaccion + `lockForUpdate` + estado `received` para idempotencia basica. **Pendiente:** firma y endpoint de ingesta duro (ver `docs/INTEGRACIONES_HARDENING.md`). |
| Pruebas minimas | `tests/Feature/Security/RbacRouteAccessTest.php`, `RegistrationDisabledTest.php`, `tests/Unit/DemoUserSeederProductionGuardTest.php`. |
| Password hashing | `UserFactory` y `DemoUserSeeder` alineados al cast `hashed` del modelo `User`. |

## 10. Clasificacion institucional recomendada (post-cierre parcial)

- **Listo para piloto / produccion controlada:** cuando el checklist `CHECKLIST_GO_NO_GO_PRODUCCION.md` este en **OK** en los items criticos (entorno, colas, scheduler, seeders, HTTPS) y las integraciones externas sigan **desactivadas** o en modo documentado.
- **No listo para produccion general** mientras las integraciones se consideren productivas sin OAuth, firmas de webhook, cifrado de tokens y backup/DR probado.

Ver justificacion detallada en `DIAGNOSTICO_PRODUCCION.md`.
