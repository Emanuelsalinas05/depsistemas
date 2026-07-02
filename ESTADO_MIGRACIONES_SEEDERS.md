# 📊 Estado de Migraciones y Seeders

## ✅ Migraciones Creadas

### Total: **49 Migraciones**

#### Migraciones Base de Laravel (4)
- ✅ `0001_01_01_000000_create_users_table.php`
- ✅ `0001_01_01_000001_create_cache_table.php`
- ✅ `0001_01_01_000002_create_jobs_table.php`
- ✅ `2026_01_09_172604_create_permission_tables.php` (Spatie)

#### Migraciones Spatie Activity Log (3)
- ✅ `2026_01_09_172720_create_activity_log_table.php`
- ✅ `2026_01_09_172721_add_event_column_to_activity_log_table.php`
- ✅ `2026_01_09_172722_add_batch_uuid_column_to_activity_log_table.php`

#### Migraciones MVP Fase 1 (22)
- ✅ `2026_01_10_100000_create_tecnologias_table.php`
- ✅ `2026_01_10_100100_create_sistemas_table.php`
- ✅ `2026_01_10_100200_create_proyectos_table.php`
- ✅ `2026_01_10_100300_create_proyecto_miembros_table.php`
- ✅ `2026_01_10_100400_create_sistema_tecnologia_table.php`
- ✅ `2026_01_10_100500_create_servidores_table.php`
- ✅ `2026_01_10_100600_create_ambientes_table.php`
- ✅ `2026_01_10_100700_create_servicios_table.php`
- ✅ `2026_01_10_100800_create_tareas_table.php`
- ✅ `2026_01_10_100900_create_tarea_dependencias_table.php`
- ✅ `2026_01_10_101000_create_releases_table.php`
- ✅ `2026_01_10_101100_create_release_tarea_table.php`
- ✅ `2026_01_10_101200_create_plantillas_documento_table.php`
- ✅ `2026_01_10_101300_create_documentos_table.php`
- ✅ `2026_01_10_101400_create_documento_versiones_table.php`
- ✅ `2026_01_10_101500_create_reuniones_table.php`
- ✅ `2026_01_10_101600_create_reunion_asistentes_table.php`
- ✅ `2026_01_10_101700_create_minutas_table.php`
- ✅ `2026_01_10_101800_create_acuerdos_table.php`
- ✅ `2026_01_10_101900_create_recordatorios_table.php`
- ✅ `2026_01_10_102000_create_bitacoras_diarias_table.php`
- ✅ `2026_01_10_102100_create_contactos_table.php`
- ✅ `2026_01_10_102200_create_contacto_interacciones_table.php`

#### Migraciones V2 Adicionales (20)
- ✅ `2026_01_10_200000_create_comentarios_table.php`
- ✅ `2026_01_10_200100_create_comentario_lecturas_table.php`
- ✅ `2026_01_10_200200_create_worklogs_table.php`
- ✅ `2026_01_10_200300_create_capacidad_usuario_table.php`
- ✅ `2026_01_10_200400_create_checklists_table.php`
- ✅ `2026_01_10_200500_create_checklist_items_table.php`
- ✅ `2026_01_10_200600_create_etiquetas_table.php`
- ✅ `2026_01_10_200700_create_tarea_etiqueta_table.php`
- ✅ `2026_01_10_200800_create_documento_etiqueta_table.php`
- ✅ `2026_01_10_200900_create_favoritos_table.php`
- ✅ `2026_01_10_201000_create_contacto_sistema_table.php`
- ✅ `2026_01_10_201100_create_contacto_proyecto_table.php`
- ✅ `2026_01_10_201200_create_github_installations_table.php`
- ✅ `2026_01_10_201300_create_github_repositories_table.php`
- ✅ `2026_01_10_201400_create_github_webhook_events_table.php`
- ✅ `2026_01_10_201500_create_reportes_jasper_table.php`
- ✅ `2026_01_10_201600_create_reportes_ejecuciones_table.php`
- ✅ `2026_01_10_201700_create_ia_prompts_table.php`
- ✅ `2026_01_10_201800_create_ia_generaciones_table.php`

## ✅ Seeders Creados

### Total principal: **Roles + opcional admin inicial + opcional demo**

1. ✅ `DatabaseSeeder.php` — Orquestador
   - Siempre: `RolesAndPermissionsSeeder`
   - Siempre: `InitialAdminSeeder` (no crea nada si faltan `INITIAL_ADMIN_*`)
   - **Solo no producción y con `SEED_DEMO_DATA=true`:** `DemoUserSeeder`
   - En `APP_ENV=production` **nunca** se ejecuta `DemoUserSeeder` desde aquí.

2. ✅ `RolesAndPermissionsSeeder.php` — Completo
   - Crea todos los roles (superadmin, pm, dev, qa, soporte, consulta)
   - Crea todos los permisos granulares
   - Asigna permisos a roles según matriz definida

3. ✅ `InitialAdminSeeder.php` — Producción / primer arranque
   - Crea usuario `INITIAL_ADMIN_EMAIL` con rol `superadmin` si las variables están definidas.
   - En `production` exige contraseña fuerte (12+ complejidad).
   - Ver `README_PRODUCCION.md`.

4. ✅ `DemoUserSeeder.php` — **Solo desarrollo / staging controlado**
   - Crea cuatro usuarios `@example.com` (admin, pm, dev, qa) y datos demo si se invoca.
   - **Lanza excepción** si `APP_ENV=production`.
   - No imprime credenciales en consola.

5. ✅ `AsignarPermisosRolesSeeder.php` — (Posiblemente obsoleto; preferir `RolesAndPermissionsSeeder`)
6. ✅ `PermisosSeeder.php` — (Posiblemente obsoleto)
7. ✅ `RolesSeeder.php` — (Posiblemente obsoleto)

## ⚠️ Estado de Ejecución

**NO SE HA VERIFICADO SI SE HAN EJECUTADO**

Para verificar y ejecutar:

### 1. Verificar Estado de Migraciones
```bash
php artisan migrate:status
```

### 2. Ejecutar Migraciones
```bash
php artisan migrate
```

### 3. Ejecutar Seeders
```bash
php artisan db:seed
```

O ejecutar seeders específicos:
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
php artisan db:seed --class=InitialAdminSeeder
# Solo desarrollo / staging (nunca producción):
SEED_DEMO_DATA=true php artisan db:seed --class=DemoUserSeeder
```

### 4. Ejecutar Todo (Fresh)
Si quieres empezar desde cero:
```bash
php artisan migrate:fresh --seed
```

⚠️ **ADVERTENCIA**: `migrate:fresh` elimina todas las tablas y datos.

## 📋 Checklist de Ejecución

- [ ] Verificar que la base de datos esté configurada en `.env`
- [ ] Ejecutar `php artisan migrate:status` para ver estado
- [ ] Ejecutar `php artisan migrate` si hay migraciones pendientes
- [ ] Ejecutar `php artisan db:seed` para roles y permisos (+ admin inicial si `INITIAL_ADMIN_*` está definido)
- [ ] **Producción:** confirmar que **no** existen usuarios `@example.com` ni `SEED_DEMO_DATA=true`
- [ ] **Desarrollo:** si se requiere demo, usar `SEED_DEMO_DATA=true` y revisar credenciales locales

## 🔍 Verificación Post-Ejecución

Después de ejecutar los seeders, deberías poder:

1. **Login:**
   - Producción: usuario creado vía `InitialAdminSeeder` o provisión institucional (LDAP/SSO futuro).
   - Desarrollo (solo si `SEED_DEMO_DATA=true`): usuarios `@example.com` — ver `DemoUserSeeder.php`.

2. **Ver en la base de datos:**
   - Tabla `roles` con 6 roles
   - Tabla `permissions` con todos los permisos
   - Tabla `users` con usuarios demo
   - Tabla `sistemas` con 1 sistema demo
   - Tabla `proyectos` con 1 proyecto demo
   - Tabla `tareas` con 5 tareas demo

3. **Verificar permisos:**
   - Superadmin debe tener todos los permisos
   - PM debe tener permisos de gestión de proyectos
   - Dev debe tener permisos limitados

## 📝 Notas Importantes

1. **Orden de ejecución:**
   - Primero migraciones (crean tablas)
   - Luego seeders (llenan datos)

2. **Si hay errores:**
   - Verificar que MySQL esté corriendo
   - Verificar configuración de BD en `.env`
   - Verificar que las migraciones estén en orden correcto
   - Revisar logs en `storage/logs/laravel.log`

3. **Seeders duplicados:**
   - `RolesAndPermissionsSeeder` es el seeder completo y actualizado
   - Los otros seeders (AsignarPermisosRolesSeeder, PermisosSeeder, RolesSeeder) pueden estar obsoletos
   - Solo usar `RolesAndPermissionsSeeder` y `DemoUserSeeder`

## ✅ Conclusión

**Todas las migraciones y seeders están CREADOS y LISTOS para ejecutar.**

Solo falta ejecutarlos con los comandos de Laravel.
