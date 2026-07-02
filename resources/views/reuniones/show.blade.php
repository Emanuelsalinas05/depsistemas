<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $reunion->titulo }}
            </h2>
            <div class="flex gap-2">
                @can('update', $reunion)
                    <a href="{{ route('reuniones.edit', $reunion) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Editar
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Contenido Principal -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Información General -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información</h3>
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha y Hora</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $reunion->fecha_inicio->format('d/m/Y H:i') }}
                                    @if($reunion->fecha_fin)
                                        - {{ $reunion->fecha_fin->format('H:i') }}
                                    @endif
                                </dd>
                            </div>
                            @if($reunion->ubicacion)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ubicación</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $reunion->ubicacion }}</dd>
                                </div>
                            @endif
                            @if($reunion->proyecto)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Proyecto</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('proyectos.show', $reunion->proyecto) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            {{ $reunion->proyecto->nombre }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if($reunion->descripcion)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $reunion->descripcion }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Asistentes -->
                    @include('reuniones.partials._asistentes', ['reunion' => $reunion])

                    <!-- Minuta -->
                    @include('reuniones.partials._minuta', ['reunion' => $reunion])

                    <!-- Acuerdos -->
                    @include('reuniones.partials._acuerdos', ['reunion' => $reunion])
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Acciones Rápidas -->
                    @can('create', \App\Models\Acuerdo::class)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones</h3>
                            <div class="space-y-2">
                                <a href="{{ route('acuerdos.create', ['reunion_id' => $reunion->id]) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Nuevo Acuerdo
                                </a>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
