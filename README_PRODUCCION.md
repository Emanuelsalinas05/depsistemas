# Despliegue en producción institucional (Laravel 11)

Este documento describe los pasos **exactos** y las decisiones mínimas para desplegar la aplicación fuera de un entorno de desarrollo local. Complementa `README_OPERATIVO.md` (operación diaria) y debe leerse junto con `CHECKLIST_GO_NO_GO_PRODUCCION.md`.

## 1. Prerrequisitos del servidor

- PHP 8.2+ con extensiones habituales de Laravel (`openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, recomendado `intl`).
- Composer 2.x.
- Node 18+ / npm (solo si compila assets en el servidor; alternativa: compilar en CI y publicar `public/build`).
- MySQL 8 (recomendado) u otro motor soportado por Eloquent.
- Servidor web (Nginx o IIS) o PHP-FPM detrás de balanceador con **HTTPS terminado**.
- **Cron** o programador de tareas para `php artisan schedule:run` cada minuto.
- **Worker** de colas (`php artisan queue:work`) supervisado (Supervisor, systemd o Windows Service).

## 2. Variables de entorno (`.env`)

1. Copiar `.env.example` a `.env`.
2. Generar clave: `php artisan key:generate`.
3. Configurar como mínimo:

| Variable | Producción institucional |
|----------|--------------------------|
| `APP_NAME` | Nombre visible del sistema |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | URL pública `https://...` |
| `APP_FORCE_HTTPS` | `true` si todo el tráfico debe ser HTTPS |
| `FORCE_HSTS` | `true` solo si HTTPS está correctamente terminado en el cliente |
| `TRUSTED_PROXIES` | IPs del balanceador o `*` según política de red |
| `DB_*` | Credenciales de base de datos |
| `SESSION_DRIVER` | `database` o `redis` |
| `SESSION_ENCRYPT` | `true` recomendado en institucional |
| `QUEUE_CONNECTION` | `database` o `redis` (evitar `sync`) |
| `CACHE_STORE` | `redis` o `database` |
| `MAIL_*` | Si se usan recordatorios u otras notificaciones |
| `SEED_DEMO_DATA` | **`false` u omitida** (nunca `true` en producción) |
| `INITIAL_ADMIN_*` | Solo en **primer** despliegue controlado (ver §4) |
| `DISABLE_REGISTRATION` | `true` salvo política explícita de registro abierto |

> **Secretos:** no commitear `.env`. Preferir gestor de secretos institucional o variables inyectadas por el pipeline.

## 3. Instalación de dependencias y optimización

```bash
composer install --no-dev --optimize-autoloader
```

Assets (si aplica en el mismo host):

```bash
npm ci
npm run build
```

Optimización Laravel:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

## 4. Base de datos y semillas seguras

```bash
php artisan migrate --force
```

### 4.1 Semillas en producción

- `php artisan db:seed --force` ejecuta `DatabaseSeeder`, que **siempre** incluye `RolesAndPermissionsSeeder` e `InitialAdminSeeder`.
- **`DemoUserSeeder` no se ejecuta en `APP_ENV=production`** y además lanza excepción si se invoca manualmente en producción.
- Datos demo solo si `APP_ENV` **no** es `production` **y** `SEED_DEMO_DATA=true`.

### 4.2 Usuario inicial (`InitialAdminSeeder`)

Definir **solo para el primer arranque** (o vía pipeline seguro):

```env
INITIAL_ADMIN_EMAIL=admin.institucional@dominio.gob
INITIAL_ADMIN_PASSWORD='(contraseña fuerte, 12+ con complejidad)'
INITIAL_ADMIN_NAME="Administrador"
```

Ejecutar:

```bash
php artisan db:seed --class=InitialAdminSeeder --force
```

Luego **eliminar** `INITIAL_ADMIN_PASSWORD` del entorno y rotar credencial si el valor quedó en historial de despliegue.

## 5. Storage y enlaces simbólicos

```bash
php artisan storage:link
```

Verificar permisos de escritura en `storage/` y `bootstrap/cache/` para el usuario del servicio web / worker.

## 6. Colas de trabajo

Con `QUEUE_CONNECTION=database` (u otro distinto de `sync`):

```bash
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

En producción use supervisor/systemd. Ejemplos en `deploy/supervisor-laravel-worker.conf.example`.

Monitorear `failed_jobs` y configurar alertas.

## 7. Programador (scheduler)

Crontab (Linux):

```cron
* * * * * cd /ruta/al/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

Windows Server: Tarea programada cada minuto con el mismo comando.

## 8. Endurecimiento ya aplicado en código

- Cabeceras HTTP mínimas (`SecurityHeaders`) y correlación `X-Request-Id` (`AssignRequestId`).
- Confianza de proxies configurable (`TRUSTED_PROXIES`).
- `URL::forceScheme('https')` si `APP_FORCE_HTTPS=true`.
- Límite de intentos de login configurable (`LOGIN_MAX_ATTEMPTS`) + `throttle` en ruta POST `/login`.
- Registro público deshabilitado por defecto en `APP_ENV=production` (`config/app.php` → `disable_registration`).
- `ProcesarWebhookJob`: transacción + `lockForUpdate` + estado `received` para **idempotencia** básica ante reintentos.
- Seeders demo aislados por entorno y variable `SEED_DEMO_DATA`.

## 9. HTTPS y cookies

- Terminar TLS en el balanceador o en el propio servidor.
- Ajustar `SESSION_SECURE_COOKIE=true` en `.env` cuando todo el sitio sea HTTPS (Laravel lo infiere con configuración de proxy en muchos casos; validar en navegador).

## 10. Integraciones externas

Ver `docs/INTEGRACIONES_HARDENING.md` para el estado **real** (modelado vs productivo) de GitHub, Google y correo.

## 11. Post-despliegue

- Probar login, CRUD mínimo, Kanban, publicación de documento (rol PM), worklog (rol dev).
- Verificar que **no** existan usuarios `@example.com` ni contraseñas demo.
- Revisar `storage/logs/laravel.log` y colas.

## 12. Rollback

- Mantener backup de BD y de `storage/app` antes de migraciones mayores.
- `php artisan migrate:rollback --step=1` solo en ventana controlada (no sustituye backup).
