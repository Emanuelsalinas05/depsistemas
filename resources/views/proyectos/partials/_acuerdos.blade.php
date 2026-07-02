<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium">Acuerdos del Proyecto</h3>
        @can('create', \App\Models\Acuerdo::class)
            <a href="{{ route('acuerdos.create', ['proyecto_id' => $proyecto->id]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                Nuevo Acuerdo
            </a>
        @endcan
    </div>
    
    @php
        $acuerdos = $proyecto->acuerdos()->orderBy('fecha_compromiso', 'asc')->get();
        $vencidos = $acuerdos->filter(fn($a) => $a->fecha_compromiso && $a->fecha_compromiso < now() && !in_array($a->estatus, ['cumplido', 'cancelado']));
    @endphp
    
    @if($vencidos->count() > 0)
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded">
            <p class="text-sm font-medium text-red-800">{{ $vencidos->count() }} acuerdo(s) vencido(s)</p>
        </div>
    @endif
    
    @if($acuerdos->count() > 0)
        <div class="space-y-3">
            @foreach($acuerdos->take(10) as $acuerdo)
                <div class="border rounded p-4 {{ $acuerdo->fecha_compromiso && $acuerdo->fecha_compromiso < now() && !in_array($acuerdo->estatus, ['cumplido', 'cancelado']) ? 'border-red-300 bg-red-50' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <a href="{{ route('acuerdos.show', $acuerdo) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                {{ $acuerdo->titulo }}
                            </a>
                            <div class="flex items-center gap-2 mt-2">
                                <x-badge-status type="acuerdo" :value="$acuerdo->estatus" />
                                @if($acuerdo->fecha_compromiso)
                                    <span class="text-sm text-gray-500">
                                        Vence: {{ $acuerdo->fecha_compromiso->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <x-empty-state title="No hay acuerdos" description="Aún no se han registrado acuerdos para este proyecto." />
    @endif
</div>
