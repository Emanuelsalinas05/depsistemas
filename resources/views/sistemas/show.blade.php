<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $sistema->nombre }}
            </h2>
            <div class="flex gap-2">
                @can('update', $sistema)
                    <a href="{{ route('sistemas.edit', $sistema) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Editar
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabs -->
            @include('sistemas._tabs', ['sistema' => $sistema, 'active' => request('tab', 'general')])

            <!-- Contenido de Tabs -->
            <div class="bg-white shadow-sm sm:rounded-lg mt-6">
                @if(request('tab', 'general') === 'general')
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sistema->nombre }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sistema->slug }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sistema->descripcion ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Área Usuaria</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sistema->area_usuaria ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Dueño Funcional</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $sistema->dueno_funcional ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Criticidad</dt>
                                <dd class="mt-1">
                                    <x-badge-status type="criticidad" :value="$sistema->criticidad" />
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estatus</dt>
                                <dd class="mt-1">
                                    <x-badge-status type="sistema" :value="$sistema->estatus" />
                                </dd>
                            </div>
                            @if($sistema->url_prod)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">URL Producción</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ $sistema->url_prod }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            {{ $sistema->url_prod }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            @if($sistema->repositorio_url)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Repositorio</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="{{ $sistema->repositorio_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            {{ $sistema->repositorio_url }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @elseif(request('tab') === 'tecnologias')
                    @include('sistemas.partials._tecnologias', ['sistema' => $sistema])
                @elseif(request('tab') === 'ambientes')
                    @include('sistemas.partials._ambientes', ['sistema' => $sistema])
                @elseif(request('tab') === 'releases')
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Releases</h3>
                        @if($sistema->releases->count() > 0)
                            <div class="space-y-4">
                                @foreach($sistema->releases as $release)
                                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                                        <div class="flex justify-between">
                                            <span class="font-medium">{{ $release->version }}</span>
                                            <span class="text-sm text-gray-500">{{ $release->fecha_release ? $release->fecha_release->format('d/m/Y') : '-' }}</span>
                                        </div>
                                        @if($release->changelog)
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($release->changelog, 100) }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <x-empty-state title="No hay releases" description="Aún no se han registrado releases para este sistema." />
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
