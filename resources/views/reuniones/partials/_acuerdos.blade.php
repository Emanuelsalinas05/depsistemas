<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Acuerdos</h3>
        @can('create', \App\Models\Acuerdo::class)
            <a href="{{ route('acuerdos.create', ['reunion_id' => $reunion->id]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                Nuevo Acuerdo
            </a>
        @endcan
    </div>
    
    @if($reunion->acuerdos->count() > 0)
        <div class="space-y-3">
            @foreach($reunion->acuerdos as $acuerdo)
                <div class="border rounded p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <a href="{{ route('acuerdos.show', $acuerdo) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                {{ $acuerdo->titulo }}
                            </a>
                            <div class="flex items-center gap-2 mt-2">
                                <x-badge-status type="acuerdo" :value="$acuerdo->estatus" />
                                @if($acuerdo->responsable)
                                    <span class="text-sm text-gray-500">Responsable: {{ $acuerdo->responsable->name }}</span>
                                @endif
                                @if($acuerdo->fecha_compromiso)
                                    <span class="text-sm text-gray-500">
                                        Vence: {{ $acuerdo->fecha_compromiso->format('d/m/Y') }}
                                        @if($acuerdo->fecha_compromiso < now() && !in_array($acuerdo->estatus, ['cumplido', 'cancelado']))
                                            <span class="text-red-600 font-medium">(Vencido)</span>
                                        @endif
                                    </span>
                                @endif
                            </div>
                            @if($acuerdo->detalle)
                                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($acuerdo->detalle, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">No hay acuerdos registrados para esta reunión.</p>
    @endif
</div>
