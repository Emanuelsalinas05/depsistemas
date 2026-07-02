<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Agregar Versión - {{ $documento->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('documentos.add-version', $documento) }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-input-label for="version" value="Versión *" />
                            <x-text-input id="version" name="version" type="text" class="mt-1 block w-full" value="{{ old('version') }}" placeholder="ej: 1.0.0" required />
                            <p class="mt-1 text-sm text-gray-500">Formato: mayor.menor.parche (ej: 1.0.0, 1.1.0, 2.0.0)</p>
                            <x-input-error class="mt-2" :messages="$errors->get('version')" />
                        </div>

                        <div>
                            <x-input-label for="contenido" value="Contenido (Markdown)" />
                            <textarea id="contenido" name="contenido" rows="15" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm font-mono text-sm">{{ old('contenido') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('contenido')" />
                        </div>

                        <div>
                            <x-input-label for="mermaid_source" value="Código Mermaid (opcional)" />
                            <textarea id="mermaid_source" name="mermaid_source" rows="5" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm font-mono text-sm" placeholder="graph TD&#10;    A[Start] --> B[End]">{{ old('mermaid_source') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('mermaid_source')" />
                        </div>

                        <div>
                            <x-input-label for="archivo_path" value="Ruta de Archivo (opcional)" />
                            <x-text-input id="archivo_path" name="archivo_path" type="text" class="mt-1 block w-full" value="{{ old('archivo_path') }}" placeholder="documentos/archivo.pdf" />
                            <x-input-error class="mt-2" :messages="$errors->get('archivo_path')" />
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('documentos.show', $documento) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Agregar Versión
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
