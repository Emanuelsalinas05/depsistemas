<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Reunión') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('reuniones.update', $reunion) }}">
                    @csrf
                    @method('PUT')
                    @include('reuniones.partials._form', ['reunion' => $reunion])
                    
                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('reuniones.show', $reunion) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Actualizar Reunión
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
