# Historias de Usuario y Diagramas UML - Base de trabajo

## 1. Objetivo
Definir historias de usuario priorizadas y un set minimo de diagramas UML para documentar el comportamiento del sistema actual.

## 2. Plantilla de historia de usuario
Use este formato para cada historia:

```markdown
ID: HU-XXX
Como [rol]
Quiero [objetivo]
Para [beneficio]

Criterios de aceptacion:
- [ ] CA-1 ...
- [ ] CA-2 ...
- [ ] CA-3 ...

Reglas de negocio:
- RB-...

Permisos:
- permiso.spatie

Definicion de terminado:
- [ ] validacion request
- [ ] policy aplicada
- [ ] prueba feature
- [ ] evidencia UAT
```

## 3. Historias de usuario iniciales (MVP)

### HU-001 Gestionar sistemas
- **Como** PM/Superadmin
- **Quiero** crear y mantener sistemas
- **Para** centralizar informacion tecnica y operativa

### HU-002 Gestionar miembros de proyecto
- **Como** PM
- **Quiero** asignar miembros y roles por proyecto
- **Para** controlar responsabilidades y alcance

### HU-003 Operar tablero kanban
- **Como** Dev/QA/PM
- **Quiero** mover tareas entre estados segun permisos
- **Para** reflejar avance real del trabajo

### HU-004 Publicar documento
- **Como** PM/Superadmin
- **Quiero** publicar documentos versionados
- **Para** asegurar contenido oficial y trazable

### HU-005 Convertir acuerdos a tarea
- **Como** PM
- **Quiero** convertir acuerdos de reunion a tareas
- **Para** asegurar ejecucion de compromisos

### HU-006 Registrar worklog
- **Como** Dev
- **Quiero** registrar tiempo por tarea
- **Para** medir carga y productividad

### HU-007 Ver reportes operativos
- **Como** PM
- **Quiero** revisar carga por dev y acuerdos vencidos
- **Para** tomar decisiones de seguimiento

## 4. Backlog sugerido por prioridad
- **Alta:** HU-002, HU-003, HU-004, HU-006
- **Media:** HU-001, HU-005
- **Baja:** HU-007 y extensiones analiticas

## 5. UML recomendado (minimo)

### 5.1 Diagrama de casos de uso
Actores:
- Superadmin
- PM
- Dev
- QA
- Soporte
- Consulta

Casos de uso minimos:
- Gestionar sistemas
- Gestionar proyectos y miembros
- Gestionar tareas
- Mover estado de tarea
- Publicar documento
- Registrar worklog
- Gestionar reuniones/acuerdos
- Consultar reportes

### 5.2 Diagrama de actividades
Flujos clave:
1. Ciclo de tarea: crear -> asignar -> mover estado -> cerrar
2. Documento: crear -> versionar -> publicar
3. Reunion: crear -> minuta -> acuerdo -> convertir a tarea

### 5.3 Diagrama de secuencia
Secuencias sugeridas:
- `moveState` (UI -> Controller -> Policy -> Model -> respuesta)
- `publish` de documento
- `toTask` desde acuerdo (transaccion)

### 5.4 Diagrama de clases (dominio)
Clases principales:
- Sistema, Proyecto, Tarea, Documento, DocumentoVersion, Reunion, Acuerdo, Worklog, User
Relaciones:
- Usar `RELACIONES_ELOQUENT.md` como fuente canonica.

## 6. Prompt listo para generar UML con IA

```text
Actua como arquitecto de software UML.
Con base en este sistema Laravel 11 (modulos: sistemas, proyectos, tareas, documentos, reuniones, acuerdos, worklogs, reportes; RBAC con roles superadmin/pm/dev/qa/soporte/consulta), genera:
1) Diagrama de casos de uso en PlantUML.
2) Diagrama de actividades para flujo de tareas.
3) Diagrama de secuencia para publicacion de documento.
4) Diagrama de clases del dominio principal.

Condiciones:
- Mantener nombres consistentes con entidades actuales.
- Incluir restricciones por permisos donde aplique.
- Entregar codigo PlantUML y breve explicacion por diagrama.
```

## 7. Entregables esperados
- `UML_CASOS_USO.puml`
- `UML_ACTIVIDADES_TAREAS.puml`
- `UML_SECUENCIA_PUBLICAR_DOC.puml`
- `UML_CLASES_DOMINIO.puml`
