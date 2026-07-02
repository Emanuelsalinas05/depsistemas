<div class="p-6">
    <div class="mb-4">
        <a href="{{ route('tareas.kanban', $proyecto) }}" class="text-blue-600 hover:text-blue-800">
            Ver Kanban Completo →
        </a>
    </div>
    
    <div class="grid grid-cols-5 gap-4">
        @php
            $estados = ['nuevo', 'en_curso', 'en_revision', 'listo_release', 'cerrado'];
        @endphp
        
        @foreach($estados as $estado)
            <div class="bg-gray-50 rounded p-4">
                <h4 class="font-medium text-sm text-gray-700 mb-3 uppercase">
                    {{ ucfirst(str_replace('_', ' ', $estado)) }}
                </h4>
                <div class="space-y-2">
                    @foreach($proyecto->tareas->where('estado', $estado)->take(5) as $tarea)
                        <div class="bg-white p-3 rounded shadow-sm hover:shadow-md transition cursor-pointer" 
                             onclick="window.location='{{ route('tareas.show', $tarea) }}'">
                            <div class="text-sm font-medium text-gray-900">{{ $tarea->titulo }}</div>
                            @if($tarea->asignadoA)
                                <div class="text-xs text-gray-500 mt-1">{{ $tarea->asignadoA->name }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
