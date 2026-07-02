<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Calendario de Reuniones
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('reuniones.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Lista
                </a>
                @can('create', \App\Models\Reunion::class)
                    <a href="{{ route('reuniones.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Nueva Reunión
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($reuniones->map(function($reunion) {
                    $fechaFin = $reunion->fecha_fin ? $reunion->fecha_fin->toIso8601String() : $reunion->fecha_inicio->copy()->addHour()->toIso8601String();
                    return [
                        'id' => $reunion->id,
                        'title' => $reunion->titulo,
                        'start' => $reunion->fecha_inicio->toIso8601String(),
                        'end' => $fechaFin,
                        'url' => route('reuniones.show', $reunion->id),
                        'color' => $reunion->proyecto ? '#3b82f6' : '#6b7280',
                    ];
                })),
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    window.location.href = info.event.url;
                }
            });
            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>
