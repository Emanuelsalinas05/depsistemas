<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $acuerdo->titulo }}
                </h2>
                <div class="flex items-center gap-2 mt-2">
                    <x-badge-status type="acuerdo" :value="$acuerdo->estatus" />
                </div>
            </div>
            <div class="flex gap-2">
                @can('update', $acuerdo)
                    <a href="{{ route('acuerdos.edit', $acuerdo) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Editar
                    </a>
                @endcan
                @can('create', \App\Models\Tarea::class)
                    @if($acuerdo->proyecto_id && $acuerdo->estatus !== 'cumplido')
                        <form method="POST" action="{{ route('acuerdos.to-task', $acuerdo) }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Convertir a Tarea
                            </button>
                        </form>
                    @endif
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Contenido Principal -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Detalle -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detalle</h3>
                        <div class="prose max-w-none">
                            @if($acuerdo->detalle)
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $acuerdo->detalle }}</p>
                            @else
                                <p class="text-gray-400 italic">Sin detalle</p>
                            @endif
                        </div>
                    </div>

                    <!-- Comentarios -->
                    @if($acuerdo->comentarios->count() > 0)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Comentarios</h3>
                            <div class="space-y-4">
                                @foreach($acuerdo->comentarios->sortByDesc('created_at') as $comentario)
                                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <span class="text-sm font-medium text-gray-900">{{ $comentario->user->name ?? 'Usuario' }}</span>
                                                <span class="text-xs text-gray-500 ml-2">{{ $comentario->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $comentario->contenido }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Agregar Comentario -->
                    @can('create', \App\Models\Comentario::class)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Agregar Comentario</h3>
                            <form method="POST" action="{{ route('comentarios.store') }}">
                                @csrf
                                <input type="hidden" name="model_type" value="{{ get_class($acuerdo) }}">
                                <input type="hidden" name="model_id" value="{{ $acuerdo->id }}">
                                <textarea name="contenido" rows="3" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Escribe un comentario..." required></textarea>
                                <x-primary-button class="mt-2">Comentar</x-primary-button>
                            </form>
                        </div>
                    @endcan
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Información -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información</h3>
                        <dl class="space-y-4">
                            @if($acuerdo->reunion)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Reunión</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('reuniones.show', $acuerdo->reunion) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            {{ $acuerdo->reunion->titulo }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if($acuerdo->proyecto)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Proyecto</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('proyectos.show', $acuerdo->proyecto) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            {{ $acuerdo->proyecto->nombre }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if($acuerdo->responsable)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Responsable</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $acuerdo->responsable->name }}</dd>
                                </div>
                            @endif
                            @if($acuerdo->fecha_compromiso)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Compromiso</dt>
                                    <dd class="mt-1 text-sm {{ $acuerdo->fecha_compromiso < now() && !in_array($acuerdo->estatus, ['cumplido', 'cancelado']) ? 'text-red-600 font-medium' : 'text-gray-900' }}">
                                        {{ $acuerdo->fecha_compromiso->format('d/m/Y') }}
                                        @if($acuerdo->fecha_compromiso < now() && !in_array($acuerdo->estatus, ['cumplido', 'cancelado']))
                                            <span class="block text-xs mt-1">(Vencido {{ $acuerdo->fecha_compromiso->diffForHumans() }})</span>
                                        @endif
                                    </dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                <dd class="mt-1">
                                    <x-badge-status type="acuerdo" :value="$acuerdo->estatus" />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Creado</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $acuerdo->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
