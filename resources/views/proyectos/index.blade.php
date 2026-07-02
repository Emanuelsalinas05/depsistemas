<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Proyectos"
            :actions="[
                ['route' => 'proyectos.create', 'label' => 'Nuevo Proyecto', 'can' => 'proyectos.create', 'icon' => 'M12 4v16m8-8H4']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('proyectos.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <x-text-input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}" 
                            placeholder="Buscar por nombre..."
                            class="w-full"
                        />
                    </div>
                    <div>
                        <select name="estatus" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los estatus</option>
                            <option value="planeado" {{ request('estatus') === 'planeado' ? 'selected' : '' }}>Planeado</option>
                            <option value="en_progreso" {{ request('estatus') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="en_pausa" {{ request('estatus') === 'en_pausa' ? 'selected' : '' }}>En Pausa</option>
                            <option value="cerrado" {{ request('estatus') === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                        </select>
                    </div>
                    <div>
                        <x-primary-button type="submit">Filtrar</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Grid de Proyectos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($proyectos as $proyecto)
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden hover:shadow-md transition">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('proyectos.show', $proyecto) }}" class="hover:text-blue-600">
                                        {{ $proyecto->nombre }}
                                    </a>
                                </h3>
                                <x-badge-status type="proyecto" :value="$proyecto->estatus" />
                            </div>
                            
                            @if($proyecto->sistema)
                                <p class="text-sm text-gray-500 mb-2">
                                    <a href="{{ route('sistemas.show', $proyecto->sistema) }}" class="hover:text-blue-600">
                                        {{ $proyecto->sistema->nombre }}
                                    </a>
                                </p>
                            @endif
                            
                            @if($proyecto->objetivo)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $proyecto->objetivo }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div>
                                    @if($proyecto->fecha_inicio)
                                        <span>Inicio: {{ $proyecto->fecha_inicio->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                                <div>
                                    @if($proyecto->fecha_fin)
                                        <span>Fin: {{ $proyecto->fecha_fin->format('d/m/Y') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('proyectos.show', $proyecto) }}" class="text-sm text-blue-600 hover:text-blue-800">Ver</a>
                                @can('update', $proyecto)
                                    <a href="{{ route('proyectos.edit', $proyecto) }}" class="text-sm text-indigo-600 hover:text-indigo-800">Editar</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <x-empty-state 
                            title="No hay proyectos"
                            description="Aún no se han registrado proyectos."
                            :action="['href' => route('proyectos.create'), 'label' => 'Crear Proyecto']"
                        />
                    </div>
                @endforelse
            </div>
            
            @if($proyectos->hasPages())
                <div class="mt-6">
                    {{ $proyectos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
