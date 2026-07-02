<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Acuerdo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('acuerdos.update', $acuerdo) }}">
                    @csrf
                    @method('PUT')
                    @include('acuerdos.partials._form', ['acuerdo' => $acuerdo])
                    
                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('acuerdos.show', $acuerdo) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Actualizar Acuerdo
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
