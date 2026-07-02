# Integraciones externas — estado real y endurecimiento productivo

Este documento separa lo **implementado en repositorio** de lo **obligatorio** antes de considerar una integración como “productiva” en entorno institucional.

## 1. GitHub (Apps / webhooks)

### Estado en código

- Tablas: `github_installations`, `github_repositories`, `github_webhook_events`.
- Job `ProcesarWebhookJob` con procesamiento esqueleto por tipo de evento.
- Scheduler despacha jobs para eventos en estado `received` (ver `routes/console.php`).
- **Idempotencia parcial:** el job usa transacción + `lockForUpdate` y solo procesa filas en estado `received` (evita doble procesamiento concurrente del mismo registro).

### Pendiente para producción institucional

| Control | Descripción |
|---------|-------------|
| Verificación de firma | Validar `X-Hub-Signature-256` con `GITHUB_WEBHOOK_SECRET` **antes** de persistir o marcar como `received`. |
| Idempotencia por entrega | Usar `delivery_id` (único) para ignorar duplicados de red. Valorar índice único en BD. |
| Autenticación del endpoint | Si existe ruta pública de ingesta, proteger por IP, WAF o token adicional. |
| Reintentos | Política de backoff y `failed_jobs` con alerta. |
| Secretos | `GITHUB_WEBHOOK_SECRET` solo en vault / `.env` fuera de control de versiones. |

### Variables sugeridas (placeholders)

```env
GITHUB_WEBHOOK_SECRET=
# Opcional: token fine-grained / PAT solo en servidor de integración, nunca en repo
GITHUB_TOKEN=
```

---

## 2. Google Calendar / Google Drive

### Estado en código

- Migraciones y modelos para almacenar configuración de integración por usuario / sistema / proyecto.

### Pendiente para producción institucional

| Control | Descripción |
|---------|-------------|
| OAuth 2.0 | Flujo completo (authorize + callback), `state` CSRF, PKCE si aplica. |
| Refresh tokens | Almacenamiento cifrado (casts `encrypted` o cifrado de aplicación) y rotación. |
| Alcance mínimo | Usar scopes mínimos necesarios y revisión de privacidad. |
| Revocación | Manejo de `401/403` y limpieza de tokens inválidos. |
| Retención | Política de cuánto tiempo se conservan metadatos de sincronización. |

---

## 3. Correo (SMTP / API)

### Estado en código

- Tablas `email_integrations`, `email_logs` (modelado de trazabilidad).

### Pendiente para producción institucional

| Control | Descripción |
|---------|-------------|
| SPF / DKIM / DMARC | Configuración en DNS institucional (fuera de Laravel). |
| `MAIL_*` | Credenciales en secretos; probar envío desde el entorno productivo. |
| Límites y colas | Envíos masivos solo vía cola; monitorizar `failed_jobs`. |

---

## 4. Conclusión

Hasta completar la tabla de “Pendiente” por integración, el sistema debe considerarse **sin integraciones externas productivas**, aunque el modelo de datos y los jobs base existan. El checklist `CHECKLIST_GO_NO_GO_PRODUCCION.md` debe marcar **RIESGO** si se activan sin estos controles.
