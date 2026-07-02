<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $tarea->titulo }}
                </h2>
                <div class="flex items-center gap-2 mt-2">
                    <x-badge-status type="tarea" :value="$tarea->estado" />
                    <x-badge-status type="prioridad" :value="$tarea->prioridad" />
                    <span class="text-sm text-gray-500">#{{ $tarea->id }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                @can('update', $tarea)
                    <a href="{{ route('tareas.edit', $tarea) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Editar
                    </a>
                @endcan
                <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Ver Proyecto
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Columna Principal -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Descripción -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Descripción</h3>
                        <div class="prose max-w-none">
                            @if($tarea->descripcion)
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $tarea->descripcion }}</p>
                            @else
                                <p class="text-gray-400 italic">Sin descripción</p>
                            @endif
                        </div>
                    </div>

                    <!-- Comentarios -->
                    @include('tareas.partials._comentarios', ['tarea' => $tarea])

                    <!-- Checklists -->
                    @include('tareas.partials._checklists', ['tarea' => $tarea])

                    <!-- Worklogs -->
                    @include('tareas.partials._worklogs', ['tarea' => $tarea])
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Meta Información -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Proyecto</dt>
                                <dd class="mt-1">
                                    <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        {{ $tarea->proyecto->nombre }}
                                    </a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tipo</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($tarea->tipo) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Asignado a</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($tarea->asignadoA)
                                        {{ $tarea->asignadoA->name }}
                                    @else
                                        <span class="text-red-600 font-medium">Sin asignar</span>
                                    @endif
                                </dd>
                            </div>
                            @if($tarea->fecha_inicio)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Inicio</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $tarea->fecha_inicio->format('d/m/Y') }}</dd>
                                </div>
                            @endif
                            @if($tarea->fecha_fin)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Fin</dt>
                                    <dd class="mt-1 text-sm text-gray-900 {{ $tarea->fecha_fin < now() && $tarea->estado !== 'cerrado' ? 'text-red-600 font-medium' : '' }}">
                                        {{ $tarea->fecha_fin->format('d/m/Y') }}
                                    </dd>
                                </div>
                            @endif
                            @if($tarea->estimacion_horas)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estimación</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($tarea->estimacion_horas, 2) }} horas</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Progreso</dt>
                                <dd class="mt-1">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $tarea->progreso }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600">{{ $tarea->progreso }}%</span>
                                    </div>
                                </dd>
                            </div>
                            @if($tarea->evidencia_url)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Evidencia</dt>
                                    <dd class="mt-1">
                                        <a href="{{ $tarea->evidencia_url }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                            Ver PR/Commit
                                        </a>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Dependencias -->
                    @if($tarea->dependencias->count() > 0 || $tarea->dependientes->count() > 0)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Dependencias</h3>
                            @if($tarea->dependencias->count() > 0)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Depende de:</h4>
                                    <ul class="space-y-1">
                                        @foreach($tarea->dependencias as $dependencia)
                                            <li>
                                                <a href="{{ route('tareas.show', $dependencia) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                    {{ $dependencia->titulo }}
                                                </a>
                                                <x-badge-status type="tarea" :value="$dependencia->estado" />
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if($tarea->dependientes->count() > 0)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Tareas que dependen:</h4>
                                    <ul class="space-y-1">
                                        @foreach($tarea->dependientes as $dependiente)
                                            <li>
                                                <a href="{{ route('tareas.show', $dependiente) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                    {{ $dependiente->titulo }}
                                                </a>
                                                <x-badge-status type="tarea" :value="$dependiente->estado" />
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Acciones Rápidas -->
                    @can('moveState', $tarea)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones</h3>
                            <div class="space-y-2">
                                @if($tarea->estado !== 'cerrado')
                                    <form method="POST" action="{{ route('tareas.move-state', $tarea) }}" class="inline">
                                        @csrf
                                        <select name="estado" onchange="this.form.submit()" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm">
                                            <option value="">Mover estado...</option>
                                            @if($tarea->estado === 'nuevo')
                                                <option value="en_curso">En Curso</option>
                                            @endif
                                            @if(in_array($tarea->estado, ['nuevo', 'en_curso']))
                                                <option value="en_revision">En Revisión</option>
                                            @endif
                                            @if($tarea->estado === 'en_revision')
                                                <option value="listo_release">Listo Release</option>
                                            @endif
                                            @if(in_array($tarea->estado, ['listo_release', 'en_revision']))
                                                <option value="cerrado">Cerrado</option>
                                            @endif
                                        </select>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
