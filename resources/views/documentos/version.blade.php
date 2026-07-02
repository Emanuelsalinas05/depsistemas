<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Versión {{ $version->version }} - {{ $documento->titulo }}
            </h2>
            <a href="{{ route('documentos.show', $documento) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Volver al Documento
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 text-sm text-gray-500">
                    Versión: {{ $version->version }} | 
                    Creada: {{ $version->created_at->format('d/m/Y H:i') }}
                    @if($version->creador)
                        por {{ $version->creador->name }}
                    @endif
                </div>
                
                @if($version->contenido)
                    @include('documentos.partials._preview_markdown', ['version' => $version])
                @endif
                
                @if($version->mermaid_source)
                    @include('documentos.partials._mermaid_preview', ['version' => $version])
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
