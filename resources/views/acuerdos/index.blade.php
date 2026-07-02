<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Acuerdos"
            :actions="[
                ['route' => 'acuerdos.create', 'label' => 'Nuevo Acuerdo', 'can' => 'acuerdos.create', 'icon' => 'M12 4v16m8-8H4']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('acuerdos.index') }}" class="flex flex-wrap gap-4">
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
                        <select name="estatus" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los estatus</option>
                            <option value="pendiente" {{ request('estatus') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en_progreso" {{ request('estatus') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                            <option value="cumplido" {{ request('estatus') === 'cumplido' ? 'selected' : '' }}>Cumplido</option>
                            <option value="cancelado" {{ request('estatus') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
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
                    @if(request()->hasAny(['q', 'estatus', 'proyecto_id']))
                        <div>
                            <a href="{{ route('acuerdos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Limpiar</a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Lista de Acuerdos -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @if($acuerdos->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($acuerdos as $acuerdo)
                            <div class="p-6 hover:bg-gray-50 {{ $acuerdo->fecha_compromiso && $acuerdo->fecha_compromiso < now() && !in_array($acuerdo->estatus, ['cumplido', 'cancelado']) ? 'border-l-4 border-red-500 bg-red-50' : '' }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('acuerdos.show', $acuerdo) }}" class="hover:text-blue-600">
                                                {{ $acuerdo->titulo }}
                                            </a>
                                        </h3>
                                        <div class="mt-2 flex items-center gap-4 text-sm">
                                            <x-badge-status type="acuerdo" :value="$acuerdo->estatus" />
                                            @if($acuerdo->proyecto)
                                                <span class="text-gray-500">
                                                    Proyecto: <a href="{{ route('proyectos.show', $acuerdo->proyecto) }}" class="text-blue-600 hover:text-blue-800">{{ $acuerdo->proyecto->nombre }}</a>
                                                </span>
                                            @endif
                                            @if($acuerdo->reunion)
                                                <span class="text-gray-500">
                                                    Reunión: <a href="{{ route('reuniones.show', $acuerdo->reunion) }}" class="text-blue-600 hover:text-blue-800">{{ $acuerdo->reunion->titulo }}</a>
                                                </span>
                                            @endif
                                            @if($acuerdo->responsable)
                                                <span class="text-gray-500">Responsable: {{ $acuerdo->responsable->name }}</span>
                                            @endif
                                            @if($acuerdo->fecha_compromiso)
                                                <span class="{{ $acuerdo->fecha_compromiso < now() && !in_array($acuerdo->estatus, ['cumplido', 'cancelado']) ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                                    Vence: {{ $acuerdo->fecha_compromiso->format('d/m/Y') }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($acuerdo->detalle)
                                            <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $acuerdo->detalle }}</p>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('acuerdos.show', $acuerdo) }}" class="text-blue-600 hover:text-blue-800">Ver</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $acuerdos->links() }}
                    </div>
                @else
                    <x-empty-state 
                        title="No hay acuerdos"
                        description="Aún no se han registrado acuerdos."
                        :action="['href' => route('acuerdos.create'), 'label' => 'Crear Acuerdo']"
                    />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
