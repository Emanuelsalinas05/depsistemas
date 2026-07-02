<div class="p-6">
    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
        <div>
            <dt class="text-sm font-medium text-gray-500">Nombre</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $proyecto->nombre }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Estatus</dt>
            <dd class="mt-1">
                <x-badge-status type="proyecto" :value="$proyecto->estatus" />
            </dd>
        </div>
        @if($proyecto->sistema)
            <div>
                <dt class="text-sm font-medium text-gray-500">Sistema</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <a href="{{ route('sistemas.show', $proyecto->sistema) }}" class="text-blue-600 hover:text-blue-800">
                        {{ $proyecto->sistema->nombre }}
                    </a>
                </dd>
            </div>
        @endif
        @if($proyecto->fecha_inicio)
            <div>
                <dt class="text-sm font-medium text-gray-500">Fecha de Inicio</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $proyecto->fecha_inicio->format('d/m/Y') }}</dd>
            </div>
        @endif
        @if($proyecto->fecha_fin)
            <div>
                <dt class="text-sm font-medium text-gray-500">Fecha de Fin</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $proyecto->fecha_fin->format('d/m/Y') }}</dd>
            </div>
        @endif
        @if($proyecto->objetivo)
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Objetivo</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $proyecto->objetivo }}</dd>
            </div>
        @endif
    </dl>
    
    <!-- Estadísticas rápidas -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gray-50 p-4 rounded">
            <div class="text-2xl font-bold text-gray-900">{{ $proyecto->tareas->count() }}</div>
            <div class="text-sm text-gray-500">Total Tareas</div>
        </div>
        <div class="bg-gray-50 p-4 rounded">
            <div class="text-2xl font-bold text-gray-900">{{ $proyecto->tareas->whereIn('estado', ['nuevo', 'en_curso'])->count() }}</div>
            <div class="text-sm text-gray-500">En Progreso</div>
        </div>
        <div class="bg-gray-50 p-4 rounded">
            <div class="text-2xl font-bold text-gray-900">{{ $proyecto->miembros()->where('proyecto_miembros.asignacion_activa', true)->count() }}</div>
            <div class="text-sm text-gray-500">Miembros</div>
        </div>
    </div>
</div>
