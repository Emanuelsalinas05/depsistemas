<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium">Reuniones del Proyecto</h3>
        @can('create', \App\Models\Reunion::class)
            <a href="{{ route('reuniones.create', ['proyecto_id' => $proyecto->id]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                Nueva Reunión
            </a>
        @endcan
    </div>
    
    @if($proyecto->reuniones->count() > 0)
        <div class="space-y-4">
            @foreach($proyecto->reuniones->take(10) as $reunion)
                <div class="border rounded p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <a href="{{ route('reuniones.show', $reunion) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                {{ $reunion->titulo }}
                            </a>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $reunion->fecha_inicio->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <x-empty-state title="No hay reuniones" description="Aún no se han registrado reuniones para este proyecto." />
    @endif
</div>
