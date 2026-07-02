<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $plantillaDocumento->nombre }}
            </h2>
            <div class="flex gap-2">
                @can('update', $plantillaDocumento)
                    <a href="{{ route('plantillas-documento.edit', $plantillaDocumento) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Editar
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 gap-4 mb-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tipo</dt>
                        <dd class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $plantillaDocumento->tipo) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Formato</dt>
                        <dd class="mt-1 text-sm text-gray-900 uppercase">{{ $plantillaDocumento->formato }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Versión</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $plantillaDocumento->version ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd class="mt-1">
                            @if($plantillaDocumento->activa)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Activa</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Inactiva</span>
                            @endif
                        </dd>
                    </div>
                </dl>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contenido de la Plantilla</h3>
                    <div class="bg-gray-50 p-4 rounded border">
                        <pre class="text-sm text-gray-700 whitespace-pre-wrap font-mono">{{ $plantillaDocumento->contenido_template }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
