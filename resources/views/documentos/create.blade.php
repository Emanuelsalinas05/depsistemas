<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Documento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('documentos.store') }}">
                    @csrf
                    @include('documentos.partials._form')
                    
                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('documentos.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Crear Documento
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
