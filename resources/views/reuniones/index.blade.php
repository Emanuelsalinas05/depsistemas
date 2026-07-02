<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Reuniones"
            :actions="[
                ['route' => 'reuniones.create', 'label' => 'Nueva Reunión', 'can' => 'reuniones.create', 'icon' => 'M12 4v16m8-8H4'],
                ['route' => 'reuniones.calendar', 'label' => 'Calendario', 'can' => 'reuniones.viewAny', 'color' => 'green']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('reuniones.index') }}" class="flex flex-wrap gap-4">
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
                        <x-primary-button type="submit">Filtrar</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Lista de Reuniones -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @if($reuniones->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($reuniones as $reunion)
                            <div class="p-6 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('reuniones.show', $reunion) }}" class="hover:text-blue-600">
                                                {{ $reunion->titulo }}
                                            </a>
                                        </h3>
                                        <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                            <span>📅 {{ $reunion->fecha_inicio->format('d/m/Y H:i') }}</span>
                                            @if($reunion->fecha_fin)
                                                <span>- {{ $reunion->fecha_fin->format('H:i') }}</span>
                                            @endif
                                            @if($reunion->proyecto)
                                                <span>•</span>
                                                <a href="{{ route('proyectos.show', $reunion->proyecto) }}" class="hover:text-blue-600">
                                                    {{ $reunion->proyecto->nombre }}
                                                </a>
                                            @endif
                                        </div>
                                        @if($reunion->descripcion)
                                            <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $reunion->descripcion }}</p>
                                        @endif
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="text-xs text-gray-500">
                                                👥 {{ $reunion->asistentes->count() }} asistente(s)
                                            </span>
                                            @if($reunion->minuta)
                                                <span class="text-xs text-green-600">✓ Minuta</span>
                                            @endif
                                            @if($reunion->acuerdos->count() > 0)
                                                <span class="text-xs text-blue-600">{{ $reunion->acuerdos->count() }} acuerdo(s)</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('reuniones.show', $reunion) }}" class="text-blue-600 hover:text-blue-800">Ver</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $reuniones->links() }}
                    </div>
                @else
                    <x-empty-state 
                        title="No hay reuniones"
                        description="Aún no se han registrado reuniones."
                        :action="['href' => route('reuniones.create'), 'label' => 'Crear Reunión']"
                    />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
