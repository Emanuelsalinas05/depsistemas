<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-8">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-prussian-blue rounded-xl mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Confirmar Contraseña</h2>
                    <p class="text-sm text-gray-600">
                        {{ __('Por favor, confirma tu contraseña antes de continuar.') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Contraseña')" class="text-gray-700 font-medium" />
                        <div class="mt-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <x-text-input 
                                id="password" 
                                class="block w-full pl-10 border-gray-300 focus:border-prussian-blue focus:ring-prussian-blue rounded-lg shadow-sm transition"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="••••••••"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button class="w-full justify-center bg-prussian-blue hover:bg-metallic-seaweed focus:ring-prussian-blue py-3 rounded-lg">
                            {{ __('Confirmar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
