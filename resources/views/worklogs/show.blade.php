<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Worklog - {{ $worklog->tarea->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $worklog->fecha->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Usuario</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $worklog->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tarea</dt>
                        <dd class="mt-1">
                            <a href="{{ route('tareas.show', $worklog->tarea) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                {{ $worklog->tarea->titulo }}
                            </a>
                            <div class="text-xs text-gray-500">{{ $worklog->tarea->proyecto->nombre }}</div>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tiempo</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $worklog->minutos }} minutos ({{ round($worklog->minutos / 60, 2) }} horas)</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Origen</dt>
                        <dd class="mt-1">
                            <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">
                                {{ ucfirst($worklog->source) }}
                            </span>
                        </dd>
                    </div>
                    @if($worklog->descripcion)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                            <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $worklog->descripcion }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
