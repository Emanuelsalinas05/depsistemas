<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Minuta</h3>
        @can('update', $reunion)
            @if(!$reunion->minuta)
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Crear Minuta</a>
            @else
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Editar Minuta</a>
            @endif
        @endcan
    </div>
    
    @if($reunion->minuta)
        <div class="space-y-4">
            @if($reunion->minuta->resumen)
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Resumen</h4>
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $reunion->minuta->resumen }}</p>
                </div>
            @endif
            @if($reunion->minuta->decisiones)
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Decisiones</h4>
                    <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $reunion->minuta->decisiones }}</p>
                </div>
            @endif
            <div class="text-xs text-gray-500 mt-4">
                Creada: {{ $reunion->minuta->created_at->format('d/m/Y H:i') }}
                @if($reunion->minuta->creador)
                    por {{ $reunion->minuta->creador->name }}
                @endif
            </div>
        </div>
    @else
        <p class="text-sm text-gray-500 italic">Aún no se ha creado la minuta de esta reunión.</p>
    @endif
</div>
