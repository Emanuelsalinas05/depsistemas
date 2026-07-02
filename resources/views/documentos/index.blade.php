<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Documentos"
            :actions="[
                ['route' => 'documentos.create', 'label' => 'Nuevo Documento', 'can' => 'docs.create', 'icon' => 'M12 4v16m8-8H4']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros y Búsqueda -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('documentos.index') }}" class="flex flex-wrap gap-4">
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
                        <select name="sistema_id" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los sistemas</option>
                            @foreach(\App\Models\Sistema::orderBy('nombre')->get() as $sistema)
                                <option value="{{ $sistema->id }}" {{ request('sistema_id') == $sistema->id ? 'selected' : '' }}>
                                    {{ $sistema->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="tipo" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los tipos</option>
                            <option value="manual_tecnico" {{ request('tipo') === 'manual_tecnico' ? 'selected' : '' }}>Manual Técnico</option>
                            <option value="manual_usuario" {{ request('tipo') === 'manual_usuario' ? 'selected' : '' }}>Manual Usuario</option>
                            <option value="runbook" {{ request('tipo') === 'runbook' ? 'selected' : '' }}>Runbook</option>
                            <option value="adr" {{ request('tipo') === 'adr' ? 'selected' : '' }}>ADR</option>
                            <option value="postmortem" {{ request('tipo') === 'postmortem' ? 'selected' : '' }}>Postmortem</option>
                        </select>
                    </div>
                    <div>
                        <select name="estado" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Todos los estados</option>
                            <option value="borrador" {{ request('estado') === 'borrador' ? 'selected' : '' }}>Borrador</option>
                            <option value="publicado" {{ request('estado') === 'publicado' ? 'selected' : '' }}>Publicado</option>
                            <option value="archivado" {{ request('estado') === 'archivado' ? 'selected' : '' }}>Archivado</option>
                        </select>
                    </div>
                    <div>
                        <x-primary-button type="submit">Filtrar</x-primary-button>
                    </div>
                    @if(request()->hasAny(['q', 'sistema_id', 'tipo', 'estado']))
                        <div>
                            <a href="{{ route('documentos.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Limpiar</a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Grid de Documentos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($documentos as $documento)
                    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden hover:shadow-md transition">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('documentos.show', $documento) }}" class="hover:text-blue-600">
                                        {{ $documento->titulo }}
                                    </a>
                                </h3>
                                <x-badge-status type="documento" :value="$documento->estado" />
                            </div>
                            
                            <div class="flex items-center gap-2 mb-2 text-sm text-gray-500">
                                <span class="capitalize">{{ str_replace('_', ' ', $documento->tipo) }}</span>
                                @if($documento->sistema)
                                    <span>•</span>
                                    <a href="{{ route('sistemas.show', $documento->sistema) }}" class="hover:text-blue-600">
                                        {{ $documento->sistema->nombre }}
                                    </a>
                                @endif
                            </div>
                            
                            @if($documento->versiones->count() > 0)
                                <div class="text-sm text-gray-500 mb-2">
                                    Versión: {{ $documento->versiones->first()->version }}
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-between text-xs text-gray-400 mt-4">
                                <span>Creado: {{ $documento->created_at->format('d/m/Y') }}</span>
                                @if($documento->creador)
                                    <span>Por: {{ $documento->creador->name }}</span>
                                @endif
                            </div>
                            
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('documentos.show', $documento) }}" class="text-sm text-blue-600 hover:text-blue-800">Ver</a>
                                @can('update', $documento)
                                    <a href="{{ route('documentos.edit', $documento) }}" class="text-sm text-indigo-600 hover:text-indigo-800">Editar</a>
                                @endcan
                                @can('publish', $documento)
                                    @if($documento->estado !== 'publicado')
                                        <form method="POST" action="{{ route('documentos.publish', $documento) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-sm text-green-600 hover:text-green-800" onclick="return confirm('¿Publicar este documento?')">Publicar</button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <x-empty-state 
                            title="No hay documentos"
                            description="Aún no se han registrado documentos."
                            :action="['href' => route('documentos.create'), 'label' => 'Crear Documento']"
                        />
                    </div>
                @endforelse
            </div>
            
            @if($documentos->hasPages())
                <div class="mt-6">
                    {{ $documentos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
