<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Acuerdos Vencidos
            </h2>
            <a href="{{ route('reportes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('reportes.acuerdos-vencidos') }}" class="flex gap-4">
                    <div>
                        <select name="proyecto_id" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los proyectos</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}" {{ $proyectoId == $proyecto->id ? 'selected' : '' }}>
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

            <!-- Lista de Acuerdos -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @if($acuerdos->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($acuerdos as $acuerdo)
                            <div class="p-6 hover:bg-red-50 border-l-4 border-red-500">
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
                                            @if($acuerdo->responsable)
                                                <span class="text-gray-500">Responsable: {{ $acuerdo->responsable->name }}</span>
                                            @endif
                                            @if($acuerdo->fecha_compromiso)
                                                <span class="text-red-600 font-medium">
                                                    Vencido desde: {{ $acuerdo->fecha_compromiso->format('d/m/Y') }}
                                                    ({{ $acuerdo->fecha_compromiso->diffForHumans() }})
                                                </span>
                                            @endif
                                        </div>
                                        @if($acuerdo->detalle)
                                            <p class="mt-2 text-sm text-gray-600">{{ Str::limit($acuerdo->detalle, 150) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state 
                        title="No hay acuerdos vencidos"
                        description="¡Excelente! No hay acuerdos vencidos."
                    />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
