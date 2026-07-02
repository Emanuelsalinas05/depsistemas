<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gantt - {{ $proyecto->nombre }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('proyectos.show', $proyecto) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Ver Proyecto
                </a>
                <a href="{{ route('reportes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div id="gantt-container"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/frappe-gantt@latest/dist/frappe-gantt.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt@latest/dist/frappe-gantt.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tasks = @json($tareas->map(function($tarea) {
                return [
                    'id' => $tarea->id,
                    'name' => $tarea->titulo,
                    'start' => $tarea->fecha_inicio ? $tarea->fecha_inicio->format('Y-m-d') : now()->format('Y-m-d'),
                    'end' => $tarea->fecha_fin ? $tarea->fecha_fin->format('Y-m-d') : now()->addDays(7)->format('Y-m-d'),
                    'progress' => $tarea->progreso / 100,
                    'custom_class' => $tarea->estado,
                ];
            }));
            
            const gantt = new Gantt("#gantt-container", tasks, {
                view_mode: 'Month',
                language: 'es',
                on_click: function(task) {
                    window.location.href = `/tareas/${task._id}`;
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
