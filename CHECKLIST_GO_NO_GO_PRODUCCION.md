# Checklist Go / No-Go — Producción institucional

Marcar cada ítem: **OK** | **FALTA** | **RIESGO** (explicar en comentarios al pie).

| # | Ítem verificable | Estado |
|---|------------------|--------|
| 1 | `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY` definido | |
| 2 | `APP_URL` en HTTPS y coherente con enlaces generados | |
| 3 | `TRUSTED_PROXIES` acorde al balanceador / WAF | |
| 4 | `APP_FORCE_HTTPS` / cookies seguras validadas en navegador | |
| 5 | Base de datos: migraciones aplicadas (`migrate --force`) y usuario BD de mínimo privilegio | |
| 6 | **Sin** `SEED_DEMO_DATA=true` en producción; **sin** usuarios `@example.com` | |
| 7 | `INITIAL_ADMIN_*` retirado del `.env` tras bootstrap o rotación documentada | |
| 8 | `DISABLE_REGISTRATION=true` salvo política explícita de registro abierto | |
| 9 | `QUEUE_CONNECTION` distinto de `sync`; worker en ejecución y supervisado | |
|10 | Cron / Task Scheduler: `schedule:run` cada minuto | |
|11 | `php artisan storage:link` y permisos de `storage/` / `bootstrap/cache/` | |
|12 | Correo (`MAIL_*`) probado si hay recordatorios o notificaciones | |
|13 | `php artisan config:cache route:cache view:cache` ejecutados en despliegue | |
|14 | Pruebas de humo: login, listado MVP, acción por rol (PM/dev/QA) | |
|15 | Política de backup/restauración MySQL + `storage/` acordada (ver README_PRODUCCION / DIAGNOSTICO) | |
|16 | Integraciones GitHub/Google/correo: solo activas si checklist de `docs/INTEGRACIONES_HARDENING.md` está OK | |
|17 | Revisión de `failed_jobs` y alertas mínimas definidas | |
|18 | Plan de rotación de secretos y acceso administrativo (break-glass) | |

## Decisión final (completar en reunión)

- **Go** (producción): todos los ítems críticos (1–13) en **OK**, sin **RIESGO** sin mitigación.
- **Go condicionado** (producción controlada): ítems no críticos en RIESGO documentado + fecha de cierre.
- **No-Go**: cualquier ítem 1–9 en **FALTA** o **RIESGO** sin plan.

## Propuesta de clasificación del proyecto (post-auditoría)

Ver sección final de `DIAGNOSTICO_PRODUCCION.md`.
