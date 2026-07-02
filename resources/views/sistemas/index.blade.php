<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Sistemas"
            :actions="[
                ['route' => 'sistemas.create', 'label' => 'Nuevo Sistema', 'can' => 'sistemas.create', 'icon' => 'M12 4v16m8-8H4']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros y Búsqueda -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('sistemas.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <x-text-input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}" 
                            placeholder="Buscar por nombre, slug o área..."
                            class="w-full"
                        />
                    </div>
                    <div>
                        <select name="estatus" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los estatus</option>
                            <option value="activo" {{ request('estatus') === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="mantenimiento" {{ request('estatus') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                            <option value="legado" {{ request('estatus') === 'legado' ? 'selected' : '' }}>Legado</option>
                            <option value="deprecado" {{ request('estatus') === 'deprecado' ? 'selected' : '' }}>Deprecado</option>
                        </select>
                    </div>
                    <div>
                        <select name="criticidad" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todas las criticidades</option>
                            <option value="alta" {{ request('criticidad') === 'alta' ? 'selected' : '' }}>Alta</option>
                            <option value="media" {{ request('criticidad') === 'media' ? 'selected' : '' }}>Media</option>
                            <option value="baja" {{ request('criticidad') === 'baja' ? 'selected' : '' }}>Baja</option>
                        </select>
                    </div>
                    <div>
                        <x-primary-button type="submit">Filtrar</x-primary-button>
                    </div>
                    @if(request()->hasAny(['q', 'estatus', 'criticidad']))
                        <div>
                            <a href="{{ route('sistemas.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Limpiar</a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Tabla -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @if($sistemas->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área Usuaria</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criticidad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Última Release</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sistemas as $sistema)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('sistemas.show', $sistema) }}" class="hover:text-blue-600">
                                                {{ $sistema->nombre }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $sistema->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $sistema->area_usuaria ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge-status type="criticidad" :value="$sistema->criticidad" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-badge-status type="sistema" :value="$sistema->estatus" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($sistema->releases->count() > 0)
                                            {{ $sistema->releases->first()->version }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('sistemas.show', $sistema) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                        @can('update', $sistema)
                                            <a href="{{ route('sistemas.edit', $sistema) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $sistemas->links() }}
                    </div>
                @else
                    <x-empty-state 
                        title="No hay sistemas"
                        description="Aún no se han registrado sistemas."
                        :action="['href' => route('sistemas.create'), 'label' => 'Crear Sistema']"
                    />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
