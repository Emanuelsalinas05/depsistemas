<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $documento->titulo }}
                </h2>
                <div class="flex items-center gap-2 mt-2">
                    <x-badge-status type="documento" :value="$documento->estado" />
                    <span class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $documento->tipo) }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                @can('update', $documento)
                    <a href="{{ route('documentos.edit', $documento) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Editar
                    </a>
                @endcan
                @can('publish', $documento)
                    @if($documento->estado !== 'publicado')
                        <form method="POST" action="{{ route('documentos.publish', $documento) }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Publicar
                            </button>
                        </form>
                    @endif
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Contenido Principal -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Versiones -->
                    @include('documentos.partials._versions', ['documento' => $documento])

                    <!-- Preview del Contenido -->
                    @if($documento->versiones->count() > 0)
                        @php
                            $versionActual = $documento->versiones->first();
                        @endphp
                        
                        @if($versionActual->contenido)
                            @if($documento->tipo === 'manual_tecnico' || $documento->tipo === 'manual_usuario')
                                @include('documentos.partials._preview_markdown', ['version' => $versionActual])
                            @endif
                            
                            @if($versionActual->mermaid_source)
                                @include('documentos.partials._mermaid_preview', ['version' => $versionActual])
                            @endif
                        @endif
                    @else
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <p class="text-gray-500">Este documento aún no tiene versiones. Agrega una versión para ver el contenido.</p>
                        </div>
                    @endif

                    <!-- Comentarios -->
                    @if($documento->comentarios->count() > 0)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Comentarios</h3>
                            <div class="space-y-4">
                                @foreach($documento->comentarios->sortByDesc('created_at') as $comentario)
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
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Información -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información</h3>
                        <dl class="space-y-4">
                            @if($documento->sistema)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Sistema</dt>
                                    <dd class="mt-1">
                                        <a href="{{ route('sistemas.show', $documento->sistema) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            {{ $documento->sistema->nombre }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if($documento->release)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Release</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $documento->release->version }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tipo</dt>
                                <dd class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $documento->tipo) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                <dd class="mt-1">
                                    <x-badge-status type="documento" :value="$documento->estado" />
                                </dd>
                            </div>
                            @if($documento->creador)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Creado por</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $documento->creador->name }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Creado</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $documento->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Acciones -->
                    @can('addVersion', $documento)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones</h3>
                            <div class="space-y-2">
                                <a href="{{ route('documentos.add-version', $documento) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Agregar Versión
                                </a>
                            </div>
                        </div>
                    @endcan
                    
                    @can('create', \App\Models\Comentario::class)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Comentar</h3>
                            <form method="POST" action="{{ route('comentarios.store') }}">
                                @csrf
                                <input type="hidden" name="model_type" value="{{ get_class($documento) }}">
                                <input type="hidden" name="model_id" value="{{ $documento->id }}">
                                <textarea name="contenido" rows="3" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Escribe un comentario..." required></textarea>
                                <x-primary-button class="mt-2">Comentar</x-primary-button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
