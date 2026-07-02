<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Versiones</h3>
        @can('addVersion', $documento)
            <a href="{{ route('documentos.add-version', $documento) }}" class="text-sm text-blue-600 hover:text-blue-800">
                Agregar Versión
            </a>
        @endcan
    </div>
    
    @if($documento->versiones->count() > 0)
        <div class="space-y-3">
            @foreach($documento->versiones->sortByDesc('created_at') as $version)
                <div class="border-l-4 {{ $loop->first ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }} pl-4 py-3 rounded">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('documentos.show-version', ['documento' => $documento, 'version' => $version]) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                    Versión {{ $version->version }}
                                </a>
                                @if($loop->first)
                                    <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-800">Actual</span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ $version->created_at->format('d/m/Y H:i') }}
                                @if($version->creador)
                                    por {{ $version->creador->name }}
                                @endif
                            </div>
                            @if($version->archivo_path)
                                <div class="text-sm text-gray-600 mt-1">
                                    📄 <a href="{{ asset('storage/' . $version->archivo_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">Ver archivo</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">Este documento aún no tiene versiones.</p>
    @endif
</div>
