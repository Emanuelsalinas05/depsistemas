# Resumen de Relaciones Eloquent - Sistema de Gestión de Desarrollos

## Tabla de Relaciones Principales

| Modelo | Tipo | Relación | Modelo Relacionado | Método | Notas |
|--------|------|----------|-------------------|--------|-------|
| **Sistema** | hasMany | Proyectos | Proyecto | `proyectos()` | Un sistema tiene muchos proyectos |
| **Sistema** | hasMany | Ambientes | Ambiente | `ambientes()` | Un sistema tiene muchos ambientes |
| **Sistema** | belongsToMany | Tecnologías | Tecnologia | `tecnologias()` | Con pivot `version_usada` |
| **Sistema** | hasMany | Releases | Release | `releases()` | Versiones del sistema |
| **Sistema** | hasMany | Documentos | Documento | `documentos()` | Documentación del sistema |
| **Sistema** | hasMany | Repositorios GitHub | GithubRepository | `githubRepositories()` | Repositorios vinculados |
| **Sistema** | belongsToMany | Contactos | Contacto | `contactos()` | Con pivot `tipo` |
| **Sistema** | belongsTo | Creador | User | `creador()` | created_by |
| **Sistema** | belongsTo | Actualizador | User | `actualizador()` | updated_by |
| **Proyecto** | belongsTo | Sistema | Sistema | `sistema()` | nullable |
| **Proyecto** | belongsToMany | Miembros | User | `miembros()` | Con pivot `rol_en_proyecto`, `asignacion_activa` |
| **Proyecto** | hasMany | Tareas | Tarea | `tareas()` | Tareas del proyecto |
| **Proyecto** | hasMany | Reuniones | Reunion | `reuniones()` | Reuniones del proyecto |
| **Proyecto** | hasMany | Acuerdos | Acuerdo | `acuerdos()` | Acuerdos del proyecto |
| **Proyecto** | hasMany | Interacciones | ContactoInteraccion | `contactoInteracciones()` | Interacciones con contactos |
| **Proyecto** | belongsToMany | Contactos | Contacto | `contactos()` | Con pivot `tipo` |
| **Proyecto** | hasMany | Repositorios GitHub | GithubRepository | `githubRepositories()` | Repositorios vinculados |
| **Tarea** | belongsTo | Proyecto | Proyecto | `proyecto()` | Tarea pertenece a proyecto |
| **Tarea** | belongsTo | Asignado | User | `asignadoA()` | asignado_a |
| **Tarea** | belongsToMany | Etiquetas | Etiqueta | `etiquetas()` | Etiquetas de la tarea |
| **Tarea** | belongsToMany | Releases | Release | `releases()` | Releases que incluyen la tarea |
| **Tarea** | hasMany | Worklogs | Worklog | `worklogs()` | Tiempos trabajados |
| **Tarea** | morphMany | Comentarios | Comentario | `comentarios()` | Comentarios polimórficos |
| **Tarea** | morphMany | Checklists | Checklist | `checklists()` | Checklists polimórficos |
| **Tarea** | belongsToMany | Dependencias | Tarea | `dependencias()` | Tareas de las que depende |
| **Tarea** | belongsToMany | Dependientes | Tarea | `dependientes()` | Tareas que dependen de esta |
| **Documento** | belongsTo | Sistema | Sistema | `sistema()` | Documento del sistema |
| **Documento** | belongsTo | Release | Release | `release()` | nullable, versión asociada |
| **Documento** | belongsToMany | Etiquetas | Etiqueta | `etiquetas()` | Etiquetas del documento |
| **Documento** | hasMany | Versiones | DocumentoVersion | `versiones()` | Versiones del documento |
| **Documento** | morphMany | Comentarios | Comentario | `comentarios()` | Comentarios polimórficos |
| **Documento** | morphMany | Checklists | Checklist | `checklists()` | Checklists polimórficos |
| **Reunion** | belongsTo | Proyecto | Proyecto | `proyecto()` | nullable |
| **Reunion** | hasOne | Minuta | Minuta | `minuta()` | Minuta de la reunión |
| **Reunion** | hasMany | Acuerdos | Acuerdo | `acuerdos()` | Acuerdos de la reunión |
| **Reunion** | hasMany | Asistentes | ReunionAsistente | `asistentes()` | Asistentes (users o externos) |
| **Acuerdo** | belongsTo | Reunión | Reunion | `reunion()` | nullable |
| **Acuerdo** | belongsTo | Proyecto | Proyecto | `proyecto()` | nullable |
| **Acuerdo** | belongsTo | Responsable | User | `responsable()` | responsable_id, nullable |
| **Acuerdo** | morphMany | Comentarios | Comentario | `comentarios()` | Comentarios polimórficos |
| **Comentario** | morphTo | Modelo | - | `model()` | Polimórfico: Tarea, Documento, Acuerdo, etc. |
| **Comentario** | belongsTo | Usuario | User | `user()` | user_id |
| **Comentario** | hasMany | Lecturas | ComentarioLectura | `lecturas()` | Quién leyó el comentario |
| **Checklist** | morphTo | Modelo | - | `model()` | Polimórfico: Tarea, Documento, Release |
| **Checklist** | hasMany | Items | ChecklistItem | `items()` | Items del checklist |
| **Favorito** | morphTo | Modelo | - | `model()` | Polimórfico: Sistema, Proyecto, Tarea, Documento |
| **Favorito** | belongsTo | Usuario | User | `user()` | Usuario que marcó como favorito |
| **Worklog** | belongsTo | Tarea | Tarea | `tarea()` | Tarea trabajada |
| **Worklog** | belongsTo | Usuario | User | `user()` | Usuario que trabajó |
| **Contacto** | hasMany | Interacciones | ContactoInteraccion | `interacciones()` | Historial de interacciones |
| **Contacto** | belongsToMany | Sistemas | Sistema | `sistemas()` | Con pivot `tipo` |
| **Contacto** | belongsToMany | Proyectos | Proyecto | `proyectos()` | Con pivot `tipo` |
| **Release** | belongsTo | Sistema | Sistema | `sistema()` | Release del sistema |
| **Release** | belongsToMany | Tareas | Tarea | `tareas()` | Tareas incluidas en el release |
| **Release** | hasMany | Documentos | Documento | `documentos()` | Documentos del release |
| **GithubInstallation** | hasMany | Repositorios | GithubRepository | `repositories()` | Repositorios de la instalación |
| **GithubInstallation** | hasMany | Webhook Events | GithubWebhookEvent | `webhookEvents()` | Eventos recibidos |
| **GithubRepository** | belongsTo | Instalación | GithubInstallation | `installation()` | Instalación de GitHub |
| **GithubRepository** | belongsTo | Sistema | Sistema | `sistema()` | nullable |
| **GithubRepository** | belongsTo | Proyecto | Proyecto | `proyecto()` | nullable |
| **ReporteJasper** | hasMany | Ejecuciones | ReporteEjecucion | `ejecuciones()` | Ejecuciones del reporte |
| **ReporteEjecucion** | belongsTo | Reporte | ReporteJasper | `reporte()` | Reporte ejecutado |
| **ReporteEjecucion** | belongsTo | Usuario | User | `user()` | Usuario que ejecutó |
| **IaPrompt** | hasMany | Generaciones | IaGeneracion | `generaciones()` | Generaciones del prompt |
| **IaGeneracion** | belongsTo | Prompt | IaPrompt | `prompt()` | Prompt usado |
| **IaGeneracion** | belongsTo | Usuario | User | `user()` | Usuario que generó |
| **IaGeneracion** | morphTo | Modelo | - | `model()` | Opcional, referencia polimórfica |
| **User** | belongsToMany | Proyectos | Proyecto | `proyectos()` | Proyectos donde es miembro |
| **User** | hasMany | Tareas Asignadas | Tarea | `tareasAsignadas()` | Tareas asignadas |
| **User** | hasMany | Worklogs | Worklog | `worklogs()` | Tiempos trabajados |
| **User** | hasMany | Capacidad | CapacidadUsuario | `capacidad()` | Capacidad del usuario |
| **User** | hasMany | Recordatorios | Recordatorio | `recordatorios()` | Recordatorios del usuario |
| **User** | hasMany | Bitácoras | BitacoraDiaria | `bitacorasDiarias()` | Bitácoras diarias |
| **User** | hasMany | Comentarios | Comentario | `comentarios()` | Comentarios creados |
| **User** | hasMany | Favoritos | Favorito | `favoritos()` | Favoritos del usuario |
| **User** | hasMany | Acuerdos Responsable | Acuerdo | `acuerdosResponsable()` | Acuerdos donde es responsable |

## Relaciones Polimórficas

### Comentarios
- **Modelos que pueden tener comentarios**: `Tarea`, `Documento`, `Acuerdo`
- **Uso**: `$tarea->comentarios()`, `$documento->comentarios()`, `$acuerdo->comentarios()`

### Checklists
- **Modelos que pueden tener checklists**: `Tarea`, `Documento`, `Release`
- **Uso**: `$tarea->checklists()`, `$documento->checklists()`, `$release->checklists()`

### Favoritos
- **Modelos que pueden ser favoritos**: `Sistema`, `Proyecto`, `Tarea`, `Documento`
- **Uso**: `$user->favoritos()` retorna favoritos de cualquier tipo

## Relaciones Many-to-Many con Pivotes

### Sistema ↔ Tecnologia
- **Tabla pivot**: `sistema_tecnologia`
- **Campos pivot**: `version_usada`
- **Uso**: `$sistema->tecnologias()->withPivot('version_usada')->get()`

### Proyecto ↔ User (Miembros)
- **Tabla pivot**: `proyecto_miembros`
- **Campos pivot**: `rol_en_proyecto`, `asignacion_activa`
- **Uso**: `$proyecto->miembros()->withPivot('rol_en_proyecto')->get()`

### Tarea ↔ Etiqueta
- **Tabla pivot**: `tarea_etiqueta`
- **Uso**: `$tarea->etiquetas()->attach($etiquetaId)`

### Documento ↔ Etiqueta
- **Tabla pivot**: `documento_etiqueta`
- **Uso**: `$documento->etiquetas()->attach($etiquetaId)`

### Sistema ↔ Contacto
- **Tabla pivot**: `contacto_sistema`
- **Campos pivot**: `tipo`
- **Uso**: `$sistema->contactos()->withPivot('tipo')->get()`

### Proyecto ↔ Contacto
- **Tabla pivot**: `contacto_proyecto`
- **Campos pivot**: `tipo`
- **Uso**: `$proyecto->contactos()->withPivot('tipo')->get()`

## Relaciones Self-Referencing

### Tarea Dependencias
- **Tabla**: `tarea_dependencias`
- **Relaciones**: 
  - `$tarea->dependencias()` → Tareas de las que depende
  - `$tarea->dependientes()` → Tareas que dependen de esta

## Observers Registrados

Los siguientes modelos tienen observers para setear automáticamente `created_by` y `updated_by`:
- `Sistema`
- `Tarea`
- `Documento`
- `DocumentoVersion`
- `Comentario`
- `Worklog`
- `Acuerdo`
- `ContactoInteraccion`
- `ReporteJasper`
- `ReporteEjecucion`
- `GithubInstallation`

**Nota**: Los observers solo setean los campos si el usuario está autenticado (`Auth::check()`).

## Factories Disponibles

- `SistemaFactory` - Genera sistemas con datos realistas
- `ProyectoFactory` - Genera proyectos vinculados a sistemas
- `TareaFactory` - Genera tareas con estados y prioridades
- `DocumentoFactory` - Genera documentos de diferentes tipos
- `ReunionFactory` - Genera reuniones con fechas
- `AcuerdoFactory` - Genera acuerdos con estados
- `WorklogFactory` - Genera registros de tiempo trabajado

## Scopes Útiles

### Sistema
- `activos()` - Sistemas con estatus activo
- `porCriticidad($criticidad)` - Filtrar por criticidad
- `porArea($area)` - Filtrar por área usuaria

### Proyecto
- `activos()` - Proyectos en progreso
- `porEstatus($estatus)` - Filtrar por estatus
- `enRangoFechas($inicio, $fin)` - Proyectos en rango de fechas

### Tarea
- `porEstado($estado)` - Filtrar por estado
- `asignadasA($userId)` - Tareas asignadas a usuario
- `porPrioridad($prioridad)` - Filtrar por prioridad
- `enRangoFechas($inicio, $fin)` - Tareas en rango de fechas

### Acuerdo
- `porEstatus($estatus)` - Filtrar por estatus
- `pendientes()` - Acuerdos pendientes
- `porResponsable($userId)` - Acuerdos de un responsable

### Worklog
- `porUsuario($userId)` - Worklogs de un usuario
- `porRangoFechas($inicio, $fin)` - Worklogs en rango
- `porTarea($tareaId)` - Worklogs de una tarea
