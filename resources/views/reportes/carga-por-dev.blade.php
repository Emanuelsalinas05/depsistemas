<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Carga por Desarrollador
            </h2>
            <a href="{{ route('reportes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
                <form method="GET" action="{{ route('reportes.carga-por-dev') }}" class="flex gap-4">
                    <div>
                        <x-input-label for="fecha_inicio" value="Fecha Inicio" />
                        <x-text-input type="date" name="fecha_inicio" :value="$fechaInicio" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="fecha_fin" value="Fecha Fin" />
                        <x-text-input type="date" name="fecha_fin" :value="$fechaFin" class="mt-1" />
                    </div>
                    <div class="flex items-end">
                        <x-primary-button type="submit">Filtrar</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Carga -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Desarrollador</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Tareas en Curso</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Horas Trabajadas</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Minutos</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($carga as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item['usuario']->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $item['usuario']->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-lg font-semibold text-gray-900">{{ $item['tareas_en_curso'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-lg font-semibold text-blue-600">{{ $item['horas_trabajadas'] }}h</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    {{ $item['minutos_trabajados'] }} min
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
