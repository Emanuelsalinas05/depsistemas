<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Panel Izquierdo -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-prussian-blue via-metallic-seaweed to-prussian-blue relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative z-10 flex flex-col justify-center items-center text-white p-12">
                <div class="mb-8">
                    <h1 class="text-5xl font-bold mb-4">Nueva Contraseña</h1>
                    <p class="text-xl text-beau-blue/90 max-w-md text-center">
                        Establezca una contraseña segura para su cuenta de usuario.
                    </p>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-sizzling-red/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Panel Derecho -->
        <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-50 p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-prussian-blue rounded-xl mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Restablecer Contraseña</h2>
                    <p class="text-gray-600">Ingresa tu nueva contraseña</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-700 font-medium" />
                        <div class="mt-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <x-text-input 
                                id="email" 
                                class="block w-full pl-10 border-gray-300 focus:border-prussian-blue focus:ring-prussian-blue rounded-lg shadow-sm transition" 
                                type="email" 
                                name="email" 
                                :value="old('email', $request->email)" 
                                required 
                                autofocus
                                placeholder="tu@email.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Nueva Contraseña')" class="text-gray-700 font-medium" />
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
                                placeholder="••••••••"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-gray-700 font-medium" />
                        <div class="mt-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <x-text-input 
                                id="password_confirmation" 
                                class="block w-full pl-10 border-gray-300 focus:border-prussian-blue focus:ring-prussian-blue rounded-lg shadow-sm transition"
                                type="password"
                                name="password_confirmation"
                                required
                                placeholder="••••••••"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button class="w-full justify-center bg-prussian-blue hover:bg-metallic-seaweed focus:ring-prussian-blue py-3 text-base font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                            {{ __('Restablecer Contraseña') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
