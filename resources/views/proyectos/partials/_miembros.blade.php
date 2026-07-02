<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium">Miembros del Proyecto</h3>
        @can('manageMembers', $proyecto)
            <a href="{{ route('proyectos.members', $proyecto) }}" class="text-sm text-blue-600 hover:text-blue-800">
                Gestionar Miembros
            </a>
        @endcan
    </div>
    
    @if($proyecto->miembros()->where('proyecto_miembros.asignacion_activa', true)->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol en Proyecto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($proyecto->miembros()->where('proyecto_miembros.asignacion_activa', true)->get() as $miembro)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $miembro->name }}</div>
                                <div class="text-sm text-gray-500">{{ $miembro->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($miembro->pivot->rol_en_proyecto) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    Activo
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-empty-state title="No hay miembros" description="Aún no se han asignado miembros a este proyecto." />
    @endif
</div>
