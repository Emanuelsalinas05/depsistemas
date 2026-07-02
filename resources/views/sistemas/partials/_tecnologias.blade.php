<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium">Tecnologías</h3>
        @can('sistemas.manage_tech')
            <button class="text-sm text-blue-600 hover:text-blue-800">Agregar Tecnología</button>
        @endcan
    </div>
    
    @if($sistema->tecnologias->count() > 0)
        <div class="space-y-2">
            @foreach($sistema->tecnologias as $tecnologia)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <div>
                        <span class="font-medium">{{ $tecnologia->nombre }}</span>
                        @if($tecnologia->pivot->version_usada)
                            <span class="text-sm text-gray-500 ml-2">v{{ $tecnologia->pivot->version_usada }}</span>
                        @endif
                    </div>
                    @can('sistemas.manage_tech')
                        <button class="text-sm text-red-600 hover:text-red-800">Eliminar</button>
                    @endcan
                </div>
            @endforeach
        </div>
    @else
        <x-empty-state title="No hay tecnologías" description="Aún no se han asociado tecnologías a este sistema." />
    @endif
</div>
