<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi Semana - Worklogs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Selector de Semana -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('worklogs.my-week') }}" class="flex gap-4">
                    <div>
                        <x-input-label for="semana" value="Semana" />
                        <x-text-input 
                            type="week" 
                            id="semana"
                            name="semana" 
                            value="{{ request('semana', now()->format('Y-\WW')) }}" 
                            class="mt-1"
                            onchange="this.form.submit()"
                        />
                    </div>
                </form>
            </div>

            <!-- Tabla Semanal -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @php
                    $semana = request('semana', now()->format('Y-\WW'));
                    $fechaInicio = \Carbon\Carbon::parse($semana)->startOfWeek();
                    $fechaFin = $fechaInicio->copy()->endOfWeek();
                    $dias = [];
                    for ($i = 0; $i < 7; $i++) {
                        $dias[] = $fechaInicio->copy()->addDays($i);
                    }
                    $worklogsPorDia = $worklogs->groupBy(function($w) {
                        return $w->fecha->format('Y-m-d');
                    });
                @endphp

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarea</th>
                            @foreach($dias as $dia)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                    {{ $dia->format('d/m') }}<br>
                                    <span class="text-gray-400">{{ $dia->format('D') }}</span>
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $tareas = $worklogs->pluck('tarea')->unique('id');
                            $totalesPorDia = [];
                            $totalGeneral = 0;
                        @endphp
                        @foreach($tareas as $tarea)
                            <tr>
                                <td class="px-6 py-4">
                                    <a href="{{ route('tareas.show', $tarea) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        {{ $tarea->titulo }}
                                    </a>
                                    <div class="text-xs text-gray-500">{{ $tarea->proyecto->nombre }}</div>
                                </td>
                                @php
                                    $totalTarea = 0;
                                @endphp
                                @foreach($dias as $dia)
                                    @php
                                        $diaStr = $dia->format('Y-m-d');
                                        $minutosDia = $worklogs
                                            ->where('tarea_id', $tarea->id)
                                            ->where('fecha', $diaStr)
                                            ->sum('minutos');
                                        $totalTarea += $minutosDia;
                                        $totalesPorDia[$diaStr] = ($totalesPorDia[$diaStr] ?? 0) + $minutosDia;
                                    @endphp
                                    <td class="px-4 py-4 text-center text-sm">
                                        @if($minutosDia > 0)
                                            <span class="font-medium">{{ $minutosDia }}m</span>
                                            <div class="text-xs text-gray-500">({{ round($minutosDia / 60, 1) }}h)</div>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 text-center text-sm font-medium">
                                    {{ $totalTarea }}m
                                    <div class="text-xs text-gray-500">({{ round($totalTarea / 60, 1) }}h)</div>
                                </td>
                            </tr>
                        @endforeach
                        <!-- Fila de Totales -->
                        <tr class="bg-gray-50 font-medium">
                            <td class="px-6 py-4">Total</td>
                            @foreach($dias as $dia)
                                @php
                                    $diaStr = $dia->format('Y-m-d');
                                    $totalDia = $totalesPorDia[$diaStr] ?? 0;
                                    $totalGeneral += $totalDia;
                                @endphp
                                <td class="px-4 py-4 text-center">
                                    @if($totalDia > 0)
                                        {{ $totalDia }}m
                                        <div class="text-xs">({{ round($totalDia / 60, 1) }}h)</div>
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-6 py-4 text-center">
                                {{ $totalGeneral }}m
                                <div class="text-xs">({{ round($totalGeneral / 60, 1) }}h)</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Acción Rápida -->
            <div class="mt-6 bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Registrar Tiempo Rápido</h3>
                <form method="POST" action="{{ route('worklogs.store') }}" class="flex gap-4">
                    @csrf
                    <div>
                        <select name="tarea_id" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                            <option value="">Seleccionar tarea...</option>
                            @foreach(\App\Models\Tarea::where('asignado_a', auth()->id())->whereIn('estado', ['nuevo', 'en_curso'])->get() as $tarea)
                                <option value="{{ $tarea->id }}">{{ $tarea->titulo }} - {{ $tarea->proyecto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-text-input type="date" name="fecha" :value="now()->format('Y-m-d')" required />
                    </div>
                    <div>
                        <x-text-input type="number" name="minutos" placeholder="Minutos" min="1" max="1440" required />
                    </div>
                    <div>
                        <x-text-input type="text" name="descripcion" placeholder="Descripción" />
                    </div>
                    <div>
                        <x-primary-button>Registrar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
