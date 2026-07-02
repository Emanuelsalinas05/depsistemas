<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Asistentes</h3>
    
    @if($reunion->asistentes->count() > 0)
        <div class="space-y-3">
            @foreach($reunion->asistentes as $asistente)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                    <div>
                        @if($asistente->user_id)
                            <span class="font-medium text-gray-900">{{ $asistente->user->name }}</span>
                            <span class="text-sm text-gray-500 ml-2">({{ $asistente->user->email }})</span>
                        @else
                            <span class="font-medium text-gray-900">{{ $asistente->nombre_externo }}</span>
                            @if($asistente->email_externo)
                                <span class="text-sm text-gray-500 ml-2">({{ $asistente->email_externo }})</span>
                            @endif
                            <span class="text-xs text-gray-400 ml-2">Externo</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">No hay asistentes registrados.</p>
    @endif
</div>
