@php
    $tabs = [
        ['key' => 'resumen', 'label' => 'Resumen', 'href' => route('proyectos.show', $proyecto) . '?tab=resumen'],
        ['key' => 'miembros', 'label' => 'Miembros', 'href' => route('proyectos.show', $proyecto) . '?tab=miembros', 'badge' => $proyecto->miembros()->where('proyecto_miembros.asignacion_activa', true)->count()],
        ['key' => 'kanban', 'label' => 'Kanban', 'href' => route('proyectos.show', $proyecto) . '?tab=kanban'],
        ['key' => 'gantt', 'label' => 'Gantt', 'href' => route('proyectos.show', $proyecto) . '?tab=gantt'],
        ['key' => 'reuniones', 'label' => 'Reuniones', 'href' => route('proyectos.show', $proyecto) . '?tab=reuniones'],
        ['key' => 'acuerdos', 'label' => 'Acuerdos', 'href' => route('proyectos.show', $proyecto) . '?tab=acuerdos'],
    ];
@endphp

<x-tabs :items="$tabs" :active="request('tab', 'resumen')" />
