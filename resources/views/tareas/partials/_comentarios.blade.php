<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Comentarios</h3>
        @can('create', \App\Models\Comentario::class)
            <button onclick="document.getElementById('comentario-form').classList.toggle('hidden')" class="text-sm text-blue-600 hover:text-blue-800">
                Agregar Comentario
            </button>
        @endcan
    </div>

    <!-- Formulario de comentario (oculto por defecto) -->
    @can('create', \App\Models\Comentario::class)
        <div id="comentario-form" class="hidden mb-6">
            <form method="POST" action="{{ route('comentarios.store') }}">
                @csrf
                <input type="hidden" name="model_type" value="{{ get_class($tarea) }}">
                <input type="hidden" name="model_id" value="{{ $tarea->id }}">
                
                <div class="mb-4">
                    <textarea name="contenido" rows="3" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Escribe un comentario..." required></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('contenido')" />
                </div>
                
                <div class="flex items-center justify-end">
                    <button type="button" onclick="document.getElementById('comentario-form').classList.add('hidden')" class="text-gray-600 hover:text-gray-900 mr-4">
                        Cancelar
                    </button>
                    <x-primary-button type="submit">Comentar</x-primary-button>
                </div>
            </form>
        </div>
    @endcan

    <!-- Lista de comentarios -->
    @if($tarea->comentarios->count() > 0)
        <div class="space-y-4">
            @foreach($tarea->comentarios->sortByDesc('created_at') as $comentario)
                <div class="border-l-4 border-blue-500 pl-4 py-2">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="text-sm font-medium text-gray-900">{{ $comentario->user->name ?? 'Usuario' }}</span>
                            <span class="text-xs text-gray-500 ml-2">{{ $comentario->created_at->diffForHumans() }}</span>
                        </div>
                        @can('update', $comentario)
                            <div class="flex gap-2">
                                <a href="#" class="text-xs text-blue-600 hover:text-blue-800">Editar</a>
                                <form method="POST" action="{{ route('comentarios.destroy', $comentario) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800" onclick="return confirm('¿Eliminar comentario?')">Eliminar</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $comentario->contenido }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">No hay comentarios aún.</p>
    @endif
</div>
