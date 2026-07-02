# Diagnóstico de preparación para producción institucional

Fecha de referencia: auditoría interna del repositorio (post-endurecimiento en código y documentación).  
Este documento cumple los entregables **A** (semáforo) y **B** (riesgos) solicitados.

---

## A) Semáforo por área

| Área | Estado | Comentario breve |
|------|--------|------------------|
| Seguridad base (HTTPS, cookies, headers, proxies) | **ÁMBAR → verde si** se configuran `.env` (`APP_FORCE_HTTPS`, `TRUSTED_PROXIES`, `SESSION_SECURE_COOKIE`, `FORCE_HSTS` con criterio). Código: middleware de cabeceras y request-id. | Depende del despliegue real. |
| Autenticación y rate limiting | **VERDE** | `LoginRequest` + `LOGIN_MAX_ATTEMPTS` + `throttle` en POST `/login`. Registro deshabilitado por defecto en `production`. |
| RBAC (Spatie + Policies) | **ÁMBAR** | Modelo sólido; riesgo de regresión sin suite amplia. Añadidas pruebas mínimas en `tests/Feature/Security/`. |
| Seeders y datos demo | **VERDE** (con configuración) | `DemoUserSeeder` bloqueado en producción; `DatabaseSeeder` no lo invoca en `production`; admin inicial vía `InitialAdminSeeder` + env. |
| Colas y scheduler | **ÁMBAR** | Código listo; **FALTA** en servidor: worker + cron (documentado en `README_PRODUCCION.md` y `deploy/`). |
| Storage / visibilidad | **ÁMBAR** | Disco `local` privado por defecto en `config/filesystems.php`; ejecutar `storage:link` y definir política de adjuntos. |
| Integraciones (GitHub, Google, correo) | **ROJO / V2** | Modelado en BD y jobs esqueleto; **no** cerrado productivamente (OAuth, firmas, cifrado de tokens, idempotencia completa). Ver `docs/INTEGRACIONES_HARDENING.md`. |
| Observabilidad | **ÁMBAR** | `X-Request-Id` + contexto de logs básico; falta correlación centralizada/alertas (definido como política mínima en documentación). |
| Backup / DR | **ÁMBAR** | Política mínima descrita en este documento y checklist; no automatizada en código. |
| Pruebas automatizadas | **ÁMBAR** | Añadidas pruebas de seguridad mínimas; entorno CI debe tener `mbstring` etc. Suite Breeze existente. |

---

## B) Lista de riesgos (exacta / priorizada)

1. **Credenciales demo** (`admin@example.com`, etc.) si alguien fuerza `SEED_DEMO_DATA=true` en staging mal configurado o ejecuta `DemoUserSeeder` manualmente fuera de producción sin control. *Mitigación:* política de entorno + revisión de usuarios post-despliegue.
2. **Usuario inicial por env** (`INITIAL_ADMIN_PASSWORD`) puede quedar en historial de CI/CD si no se purga. *Mitigación:* secret manager, un solo uso, rotación.
3. **Registro abierto** si en producción se define `DISABLE_REGISTRATION=false` sin gobernanza de identidades. *Mitigación:* SSO institucional (futuro) o mantener registro cerrado.
4. **Proxies** mal configurados (`TRUSTED_PROXIES`) → IP/logs incorrectos o problemas con HTTPS a nivel aplicación. *Mitigación:* acotar IPs del balanceador.
5. **Colas en `sync` o sin worker** → recordatorios y webhooks no se procesan. *Mitigación:* supervisor + monitorización de `jobs` / `failed_jobs`.
6. **Scheduler ausente** → mismos síntomas que (5) para tareas periódicas.
7. **Integraciones GitHub** sin verificación criptográfica de firma en el punto de entrada HTTP (si el endpoint existe públicamente) → riesgo de eventos falsos. *Mitigación:* validar `X-Hub-Signature-256` antes de persistir (pendiente productivo).
8. **Tokens OAuth Google** en claro en BD → riesgo institucional. *Mitigación:* cifrado Laravel cast + rotación (pendiente).
9. **HSTS** activado sin HTTPS real → rotura de acceso. *Mitigación:* activar `FORCE_HSTS` solo tras prueba.
10. **Matriz RBAC** extensa sin tests exhaustivos → riesgo de escalada horizontal de permisos en evoluciones futuras. *Mitigación:* ampliar tests por recurso/acción y revisión de código en PR.

---

## Política mínima sugerida: backup y recuperación (resumen)

| Activo | Frecuencia sugerida | Retención mínima | Notas |
|--------|---------------------|------------------|-------|
| Base MySQL completa | Diaria + binlog si política lo exige | 14–30 días | Incluye roles Spatie y datos operativos |
| `storage/app` (privado y público) | Diaria si hay adjuntos/versiones de archivo | Alineada a BD | Restaurar junto con BD para coherencia |
| `.env` / secretos | Por cambio | Versionado cifrado fuera del repo | No restaurar “tal cual” sin rotación |

**RPO/RTO orientativos** (ajustar con la institución): RPO 24 h si solo backup diario; RTO 4–8 h si runbook y backups probados.

---

## H) Propuesta de clasificación del sistema

**Listo para producción controlada (piloto institucional)** cuando:

- Checklist `CHECKLIST_GO_NO_GO_PRODUCCION.md` ítems 1–13 en OK.
- Integraciones externas **desactivadas** o acotadas hasta cumplir `docs/INTEGRACIONES_HARDENING.md`.

**Aún no listo para producción general** mientras:

- Integraciones GitHub/Google/correo se consideren “productivas” sin OAuth, firmas, cifrado y runbooks.
- No exista backup/restauración probado o worker/scheduler no operen.

**Nota:** La clasificación final la firma la oficina de seguridad / TI; este repositorio aporta evidencia técnica, no sustituye el acto formal de puesta en servicio.
