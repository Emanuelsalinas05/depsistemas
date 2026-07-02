<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Registro de Tiempos</h3>
        @can('create', \App\Models\Worklog::class)
            <a href="{{ route('worklogs.create', ['tarea_id' => $tarea->id]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                Registrar Tiempo
            </a>
        @endcan
    </div>

    @php
        $totalMinutos = $tarea->worklogs->sum('minutos');
        $totalHoras = round($totalMinutos / 60, 2);
    @endphp

    @if($totalMinutos > 0)
        <div class="mb-4 p-3 bg-blue-50 rounded">
            <div class="text-sm font-medium text-gray-900">
                Total registrado: {{ $totalHoras }} horas ({{ $totalMinutos }} minutos)
            </div>
            @if($tarea->estimacion_horas)
                <div class="text-xs text-gray-600 mt-1">
                    Estimación: {{ $tarea->estimacion_horas }} horas
                    @if($totalHoras > $tarea->estimacion_horas)
                        <span class="text-red-600">({{ round($totalHoras - $tarea->estimacion_horas, 2) }}h sobre estimación)</span>
                    @endif
                </div>
            @endif
        </div>
    @endif

    @if($tarea->worklogs->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Minutos</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Origen</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tarea->worklogs->sortByDesc('fecha') as $worklog)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $worklog->fecha->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $worklog->user->name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $worklog->minutos }} min ({{ round($worklog->minutos / 60, 2) }}h)
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                {{ $worklog->descripcion ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">
                                    {{ ucfirst($worklog->source) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-sm text-gray-500 italic">No hay registros de tiempo aún.</p>
    @endif
</div>
