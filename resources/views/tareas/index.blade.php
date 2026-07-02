<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Tareas"
            :actions="[
                ['route' => 'tareas.create', 'label' => 'Nueva Tarea', 'can' => 'tareas.create', 'icon' => 'M12 4v16m8-8H4']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros y Búsqueda -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('tareas.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <x-text-input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}" 
                            placeholder="Buscar por título..."
                            class="w-full"
                        />
                    </div>
                    <div>
                        <select name="proyecto_id" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los proyectos</option>
                            @foreach(\App\Models\Proyecto::orderBy('nombre')->get() as $proyecto)
                                <option value="{{ $proyecto->id }}" {{ request('proyecto_id') == $proyecto->id ? 'selected' : '' }}>
                                    {{ $proyecto->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="estado" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los estados</option>
                            <option value="nuevo" {{ request('estado') === 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                            <option value="en_curso" {{ request('estado') === 'en_curso' ? 'selected' : '' }}>En Curso</option>
                            <option value="en_revision" {{ request('estado') === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                            <option value="listo_release" {{ request('estado') === 'listo_release' ? 'selected' : '' }}>Listo Release</option>
                            <option value="cerrado" {{ request('estado') === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                        </select>
                    </div>
                    <div>
                        <select name="asignado_a" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos</option>
                            <option value="{{ auth()->id() }}" {{ request('asignado_a') == auth()->id() ? 'selected' : '' }}>Mis Tareas</option>
                            @foreach(\App\Models\User::orderBy('name')->get() as $usuario)
                                <option value="{{ $usuario->id }}" {{ request('asignado_a') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-primary-button type="submit">Filtrar</x-primary-button>
                    </div>
                    @if(request()->hasAny(['q', 'proyecto_id', 'estado', 'asignado_a']))
                        <div>
                            <a href="{{ route('tareas.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Limpiar</a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Tabla de Tareas -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @if($tareas->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proyecto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asignado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fechas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progreso</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tareas as $tarea)
                                <tr class="hover:bg-gray-50 {{ $tarea->fecha_fin && $tarea->fecha_fin < now() && $tarea->estado !== 'cerrado' ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('tareas.show', $tarea) }}" class="hover:text-blue-600">
                                                {{ $tarea->titulo }}
                                            </a>
                                        </div>
                                        @if($tarea->descripcion)
                                            <div class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($tarea->descripcion, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            {{ $tarea->proyecto->nombre }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge-status type="tarea" :value="$tarea->estado" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge-status type="prioridad" :value="$tarea->prioridad" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($tarea->asignadoA)
                                            <div class="text-sm text-gray-900">{{ $tarea->asignadoA->name }}</div>
                                        @else
                                            <span class="text-xs text-red-600 font-medium">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($tarea->fecha_inicio && $tarea->fecha_fin)
                                            <div>{{ $tarea->fecha_inicio->format('d/m') }} - {{ $tarea->fecha_fin->format('d/m/Y') }}</div>
                                        @elseif($tarea->fecha_fin)
                                            <div>Hasta: {{ $tarea->fecha_fin->format('d/m/Y') }}</div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $tarea->progreso }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-600">{{ $tarea->progreso }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('tareas.show', $tarea) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                        @can('update', $tarea)
                                            <a href="{{ route('tareas.edit', $tarea) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $tareas->links() }}
                    </div>
                @else
                    <x-empty-state 
                        title="No hay tareas"
                        description="No se encontraron tareas con los filtros aplicados."
                        :action="['href' => route('tareas.create'), 'label' => 'Crear Tarea']"
                    />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
