<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Worklogs"
            :actions="[
                ['route' => 'worklogs.create', 'label' => 'Nuevo Worklog', 'can' => 'worklogs.create', 'icon' => 'M12 4v16m8-8H4']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('worklogs.index') }}" class="flex flex-wrap gap-4">
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
                        <select name="user_id" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los usuarios</option>
                            <option value="{{ auth()->id() }}" {{ request('user_id') == auth()->id() ? 'selected' : '' }}>Mis worklogs</option>
                            @foreach(\App\Models\User::orderBy('name')->get() as $usuario)
                                <option value="{{ $usuario->id }}" {{ request('user_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-text-input 
                            type="date" 
                            name="fecha_desde" 
                            value="{{ request('fecha_desde') }}" 
                            class="border-gray-300"
                        />
                    </div>
                    <div>
                        <x-text-input 
                            type="date" 
                            name="fecha_hasta" 
                            value="{{ request('fecha_hasta') }}" 
                            class="border-gray-300"
                        />
                    </div>
                    <div>
                        <x-primary-button type="submit">Filtrar</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Worklogs -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @if($worklogs->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarea</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiempo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Origen</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($worklogs as $worklog)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $worklog->fecha->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $worklog->user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('tareas.show', $worklog->tarea) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $worklog->tarea->titulo }}
                                        </a>
                                        <div class="text-xs text-gray-500">{{ $worklog->tarea->proyecto->nombre }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $worklog->minutos }} min ({{ round($worklog->minutos / 60, 2) }}h)
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $worklog->descripcion ? Str::limit($worklog->descripcion, 50) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">
                                            {{ ucfirst($worklog->source) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @can('update', $worklog)
                                            <a href="{{ route('worklogs.edit', $worklog) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $worklogs->links() }}
                    </div>
                @else
                    <x-empty-state 
                        title="No hay worklogs"
                        description="No se encontraron registros de tiempo con los filtros aplicados."
                        :action="['href' => route('worklogs.create'), 'label' => 'Registrar Tiempo']"
                    />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
