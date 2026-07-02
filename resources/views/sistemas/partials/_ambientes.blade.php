<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium">Ambientes</h3>
        @can('sistemas.manage_infra')
            <button class="text-sm text-blue-600 hover:text-blue-800">Agregar Ambiente</button>
        @endcan
    </div>
    
    @if($sistema->ambientes->count() > 0)
        <div class="space-y-4">
            @foreach($sistema->ambientes as $ambiente)
                <div class="border rounded p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="font-medium">{{ ucfirst($ambiente->nombre) }}</span>
                            @if($ambiente->url)
                                <a href="{{ $ambiente->url }}" target="_blank" class="text-sm text-blue-600 ml-2">{{ $ambiente->url }}</a>
                            @endif
                        </div>
                        @can('sistemas.manage_infra')
                            <button class="text-sm text-red-600 hover:text-red-800">Eliminar</button>
                        @endcan
                    </div>
                    @if($ambiente->servidor)
                        <p class="text-sm text-gray-500 mt-2">Servidor: {{ $ambiente->servidor->nombre }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <x-empty-state title="No hay ambientes" description="Aún no se han configurado ambientes para este sistema." />
    @endif
</div>
