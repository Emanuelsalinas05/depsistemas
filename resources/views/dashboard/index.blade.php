<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tarjetas de Resumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Tareas en curso (mías) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Tareas en Curso</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $tareasEnCurso ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bloqueos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Bloqueos</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $bloqueos ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acuerdos vencidos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Acuerdos Vencidos</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $acuerdosVencidos ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Releases del mes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Releases del Mes</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $releasesMes ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Mi agenda hoy -->
                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Mi Agenda Hoy</h3>
                        @if(isset($agendaHoy) && $agendaHoy->count() > 0)
                            <div class="space-y-3">
                                @foreach($agendaHoy as $item)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-2 w-2 bg-blue-500 rounded-full mt-2"></div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $item->titulo ?? $item->nombre }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->fecha_inicio ? $item->fecha_inicio->format('H:i') : '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No hay eventos programados para hoy.</p>
                        @endif
                    </div>
                </div>

                <!-- Últimos cambios -->
                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Últimos Cambios</h3>
                        @if(isset($ultimosCambios) && $ultimosCambios->count() > 0)
                            <div class="space-y-3">
                                @foreach($ultimosCambios as $cambio)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-2 w-2 bg-gray-400 rounded-full mt-2"></div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm text-gray-900">{{ $cambio->description ?? 'Cambio' }}</p>
                                            <p class="text-xs text-gray-500">{{ $cambio->created_at ? $cambio->created_at->diffForHumans() : '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No hay cambios recientes.</p>
                        @endif
                    </div>
                </div>

                <!-- Proyectos en riesgo (PM) -->
                @can('proyectos.viewAny')
                <div class="lg:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Proyectos en Riesgo</h3>
                        @if(isset($proyectosRiesgo) && $proyectosRiesgo->count() > 0)
                            <div class="space-y-3">
                                @foreach($proyectosRiesgo as $proyecto)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="h-2 w-2 bg-red-500 rounded-full mt-2"></div>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('proyectos.show', $proyecto) }}" class="hover:text-blue-600">
                                                    {{ $proyecto->nombre }}
                                                </a>
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                @if($proyecto->fecha_fin)
                                                    Vence: {{ $proyecto->fecha_fin->format('d/m/Y') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No hay proyectos en riesgo.</p>
                        @endif
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
