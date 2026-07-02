# EDR/DER de Base de Datos - Guia de generacion

## 1. Objetivo
Construir el diagrama entidad-relacion (DER/EDR) del sistema actual con base en migraciones y relaciones Eloquent implementadas.

## 2. Fuente de verdad
- Migraciones en `database/migrations/`
- Relaciones en `app/Models/`
- Resumen actual en `RELACIONES_ELOQUENT.md`
- Estado de tablas en `ESTADO_MIGRACIONES_SEEDERS.md`

## 3. Alcance del DER

### 3.1 Nucleo
- `sistemas`
- `proyectos`
- `tareas`
- `documentos`
- `reuniones`
- `acuerdos`
- `worklogs`
- `users`

### 3.2 Infraestructura
- `ambientes`, `servidores`, `servicios`, `tecnologias`
- pivotes: `sistema_tecnologia`, `proyecto_miembros`

### 3.3 Colaboracion y control
- `comentarios`, `comentario_lecturas`
- `checklists`, `checklist_items`
- `favoritos`
- `etiquetas`, `tarea_etiqueta`, `documento_etiqueta`

### 3.4 Integraciones / analitica
- `github_installations`, `github_repositories`, `github_webhook_events`
- `google_calendar_integrations`, `google_drive_integrations`
- `email_integrations`, `email_logs`
- `reportes_jasper`, `reportes_ejecuciones`
- `ia_prompts`, `ia_generaciones`

## 4. Relaciones minimas a dibujar
- Sistema 1..N Proyecto
- Proyecto N..N User (pivote proyecto_miembros)
- Proyecto 1..N Tarea
- Tarea N..1 User (asignado_a)
- Tarea N..N Etiqueta
- Tarea N..N Tarea (dependencias)
- Documento N..1 Sistema
- Documento N..1 Release (nullable)
- Documento 1..N DocumentoVersion
- Reunion N..1 Proyecto (nullable)
- Reunion 1..N Acuerdo
- Acuerdo N..1 Proyecto/Reunion/User (nullable)
- Worklog N..1 Tarea y N..1 User
- GithubInstallation 1..N GithubRepository y 1..N GithubWebhookEvent
- ReporteJasper 1..N ReporteEjecucion
- IaPrompt 1..N IaGeneracion

## 5. Consideraciones de modelado
- Identificar PK/FK de todas las tablas.
- Marcar campos nullable en relaciones opcionales.
- Marcar relaciones polimorficas:
  - `comentarios` (`model_type`, `model_id`)
  - `checklists` (`model_type`, `model_id`)
  - `favoritos` (`model_type`, `model_id`)
- Marcar tablas pivote y atributos relevantes (`rol_en_proyecto`, `version_usada`, etc.).

## 6. Prompt listo para generar DER con IA

```text
Actua como arquitecto de datos MySQL 8.
Necesito el DER/EDR de un sistema Laravel 11 con las siguientes entidades y relaciones (usar nomenclatura exacta de tablas):
- sistemas, proyectos, proyecto_miembros, tareas, tarea_dependencias, releases, release_tarea,
  plantillas_documento, documentos, documento_versiones, reuniones, reunion_asistentes, minutas,
  acuerdos, recordatorios, bitacoras_diarias, contactos, contacto_interacciones,
  comentarios, comentario_lecturas, worklogs, capacidad_usuario, checklists, checklist_items,
  etiquetas, tarea_etiqueta, documento_etiqueta, favoritos, contacto_sistema, contacto_proyecto,
  github_installations, github_repositories, github_webhook_events,
  google_calendar_integrations, google_drive_integrations, email_integrations, email_logs,
  reportes_jasper, reportes_ejecuciones, ia_prompts, ia_generaciones.

Entregar:
1) DER en Mermaid ER (`erDiagram`) con cardinalidades.
2) Diccionario de datos resumido (tabla, PK, FKs, descripcion).
3) Lista de relaciones opcionales (nullable) y polimorficas.
4) Sugerencias de indices por consultas frecuentes.
```

## 7. Salida recomendada
- `DER_SISTEMA.mmd` (Mermaid)
- `DICCIONARIO_DATOS_RESUMIDO.md`
- `RELACIONES_OPCIONALES_Y_POLIMORFICAS.md`

## 8. Validacion final del DER
Checklist:
- [ ] Todas las tablas de migraciones incluidas
- [ ] Todas las FKs mapeadas
- [ ] Polimorficas identificadas
- [ ] Pivotes identificados
- [ ] Cardinalidades revisadas con `RELACIONES_ELOQUENT.md`
