<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Plantillas de Documento"
            :actions="[
                ['route' => 'plantillas-documento.create', 'label' => 'Nueva Plantilla', 'can' => 'plantillas.manage']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tabla de Plantillas -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                @if($plantillas->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Formato</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Versión</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($plantillas as $plantilla)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('plantillas-documento.show', $plantilla) }}" class="hover:text-blue-600">
                                                {{ $plantilla->nombre }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                        {{ str_replace('_', ' ', $plantilla->tipo) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 uppercase">
                                        {{ $plantilla->formato }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $plantilla->version ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($plantilla->activa)
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Activa</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('plantillas-documento.show', $plantilla) }}" class="text-blue-600 hover:text-blue-900 mr-3">Ver</a>
                                        @can('update', $plantilla)
                                            <a href="{{ route('plantillas-documento.edit', $plantilla) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-gray-200">
                        @if($plantillas->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $plantillas->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    <x-empty-state 
                        title="No hay plantillas"
                        description="Aún no se han creado plantillas de documento."
                        :action="['href' => route('plantillas-documento.create'), 'label' => 'Crear Plantilla']"
                    />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
