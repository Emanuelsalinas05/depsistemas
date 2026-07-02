<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reportes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Carga por Desarrollador -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Carga por Desarrollador</h3>
                    <p class="text-sm text-gray-500 mb-4">Visualiza la carga de trabajo y horas registradas por cada desarrollador.</p>
                    <a href="{{ route('reportes.carga-por-dev') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Ver Reporte
                    </a>
                </div>

                <!-- Acuerdos Vencidos -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Acuerdos Vencidos</h3>
                    <p class="text-sm text-gray-500 mb-4">Lista de acuerdos con fecha de compromiso vencida.</p>
                    <a href="{{ route('reportes.acuerdos-vencidos') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Ver Reporte
                    </a>
                </div>

                <!-- Mi Gantt -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Mi Gantt</h3>
                    <p class="text-sm text-gray-500 mb-4">Visualización Gantt de tus tareas asignadas.</p>
                    <a href="{{ route('reportes.mi-gantt') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Ver Gantt
                    </a>
                </div>

                @can('jasper.view')
                <!-- Reportes Jasper -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 hover:shadow-md transition">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Reportes Jasper</h3>
                    <p class="text-sm text-gray-500 mb-4">Reportes avanzados con JasperReports.</p>
                    <a href="{{ route('reportes.jasper.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                        Ver Reportes
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
