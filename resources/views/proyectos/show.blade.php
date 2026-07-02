<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $proyecto->nombre }}
            </h2>
            <div class="flex gap-2">
                @can('update', $proyecto)
                    <a href="{{ route('proyectos.edit', $proyecto) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Editar
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabs -->
            @include('proyectos._tabs', ['proyecto' => $proyecto, 'active' => request('tab', 'resumen')])

            <!-- Contenido de Tabs -->
            <div class="bg-white shadow-sm sm:rounded-lg mt-6">
                @if(request('tab', 'resumen') === 'resumen')
                    @include('proyectos.partials._resumen', ['proyecto' => $proyecto])
                @elseif(request('tab') === 'miembros')
                    @include('proyectos.partials._miembros', ['proyecto' => $proyecto])
                @elseif(request('tab') === 'kanban')
                    @include('proyectos.partials._kanban', ['proyecto' => $proyecto])
                @elseif(request('tab') === 'gantt')
                    @include('proyectos.partials._gantt', ['proyecto' => $proyecto])
                @elseif(request('tab') === 'reuniones')
                    @include('proyectos.partials._reuniones', ['proyecto' => $proyecto])
                @elseif(request('tab') === 'acuerdos')
                    @include('proyectos.partials._acuerdos', ['proyecto' => $proyecto])
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
