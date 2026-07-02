<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kanban - {{ $proyecto->nombre }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('proyectos.show', $proyecto) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Ver Proyecto
                </a>
                @can('create', \App\Models\Tarea::class)
                    <a href="{{ route('tareas.create', ['proyecto_id' => $proyecto->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Nueva Tarea
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-5 gap-4" id="kanban-board">
                @php
                    $estados = [
                        'nuevo' => ['label' => 'Nuevo', 'color' => 'blue'],
                        'en_curso' => ['label' => 'En Curso', 'color' => 'yellow'],
                        'en_revision' => ['label' => 'En Revisión', 'color' => 'purple'],
                        'listo_release' => ['label' => 'Listo Release', 'color' => 'green'],
                        'cerrado' => ['label' => 'Cerrado', 'color' => 'gray'],
                    ];
                @endphp

                @foreach($estados as $estadoKey => $estadoInfo)
                    <div class="bg-gray-50 rounded-lg p-4" data-state="{{ $estadoKey }}">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-sm text-gray-700 uppercase">
                                {{ $estadoInfo['label'] }}
                            </h3>
                            <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded">
                                {{ $tareas->where('estado', $estadoKey)->count() }}
                            </span>
                        </div>
                        
                        <div class="space-y-3 min-h-[200px]" id="column-{{ $estadoKey }}" data-column="{{ $estadoKey }}">
                            @foreach($tareas->where('estado', $estadoKey) as $tarea)
                                <div class="bg-white p-3 rounded shadow-sm hover:shadow-md transition cursor-move border-l-4 border-{{ $estadoInfo['color'] }}-500 task-card {{ $tarea->fecha_fin && $tarea->fecha_fin < now() && $tarea->estado !== 'cerrado' ? 'border-red-500' : '' }}"
                                     data-task-id="{{ $tarea->id }}"
                                     onclick="window.location='{{ route('tareas.show', $tarea) }}'">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $tarea->titulo }}</h4>
                                        <x-badge-status type="prioridad" :value="$tarea->prioridad" />
                                    </div>
                                    
                                    @if($tarea->asignadoA)
                                        <div class="text-xs text-gray-500 mb-2">
                                            👤 {{ $tarea->asignadoA->name }}
                                        </div>
                                    @else
                                        <div class="text-xs text-red-600 font-medium mb-2">
                                            ⚠️ Sin asignar
                                        </div>
                                    @endif
                                    
                                    @if($tarea->fecha_fin)
                                        <div class="text-xs text-gray-500 mb-2">
                                            📅 {{ $tarea->fecha_fin->format('d/m/Y') }}
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex-1 bg-gray-200 rounded-full h-1.5 mr-2">
                                            <div class="bg-{{ $estadoInfo['color'] }}-500 h-1.5 rounded-full" style="width: {{ $tarea->progreso }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $tarea->progreso }}%</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 mt-2 text-xs text-gray-400">
                                        @if($tarea->comentarios->count() > 0)
                                            <span>💬 {{ $tarea->comentarios->count() }}</span>
                                        @endif
                                        @if($tarea->worklogs->sum('minutos') > 0)
                                            <span>⏱️ {{ round($tarea->worklogs->sum('minutos') / 60, 1) }}h</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const columns = document.querySelectorAll('[data-column]');
            
            columns.forEach(column => {
                new Sortable(column, {
                    group: 'kanban',
                    animation: 150,
                    onEnd: function(evt) {
                        const taskId = evt.item.dataset.taskId;
                        const newState = evt.to.dataset.column;
                        
                        // Actualizar estado via AJAX
                        fetch(`/tareas/${taskId}/move-state`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                estado: newState
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Opcional: mostrar notificación
                                console.log('Tarea movida exitosamente');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Revertir movimiento
                            evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex]);
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
