@props(['type', 'value'])

@php
    $colors = [
        'sistema' => [
            'activo' => 'green',
            'mantenimiento' => 'yellow',
            'legado' => 'gray',
            'deprecado' => 'red',
        ],
        'proyecto' => [
            'planeado' => 'blue',
            'en_progreso' => 'green',
            'en_pausa' => 'yellow',
            'cerrado' => 'gray',
        ],
        'tarea' => [
            'nuevo' => 'blue',
            'en_curso' => 'yellow',
            'en_revision' => 'purple',
            'listo_release' => 'green',
            'cerrado' => 'gray',
        ],
        'documento' => [
            'borrador' => 'yellow',
            'publicado' => 'green',
            'archivado' => 'gray',
        ],
        'acuerdo' => [
            'pendiente' => 'yellow',
            'en_progreso' => 'blue',
            'cumplido' => 'green',
            'cancelado' => 'red',
        ],
        'prioridad' => [
            'alta' => 'red',
            'media' => 'yellow',
            'baja' => 'green',
        ],
        'criticidad' => [
            'alta' => 'red',
            'media' => 'yellow',
            'baja' => 'green',
        ],
    ];
    
    $color = $colors[$type][$value] ?? 'gray';
    $label = ucfirst(str_replace('_', ' ', $value));
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
    {{ $label }}
</span>
