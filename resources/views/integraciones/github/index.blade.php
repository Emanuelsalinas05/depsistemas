<x-app-layout>
    <x-slot name="header">
        <x-page-header 
            title="Integración GitHub"
            :actions="[
                ['route' => 'github.installations.create', 'label' => 'Nueva Instalación', 'can' => 'github.manage', 'icon' => 'M12 4v16m8-8H4']
            ]"
        />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Instalaciones de GitHub</h3>
                <p class="text-gray-500">Gestión de instalaciones de GitHub App. (Implementación pendiente)</p>
            </div>
        </div>
    </div>
</x-app-layout>
