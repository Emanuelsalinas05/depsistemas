<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Panel Izquierdo -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-prussian-blue via-metallic-seaweed to-prussian-blue relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative z-10 flex flex-col justify-center items-center text-white p-12">
                <div class="mb-8">
                    <h1 class="text-5xl font-bold mb-4">Recuperar Contraseña</h1>
                    <p class="text-xl text-beau-blue/90 max-w-md text-center">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">¿Olvidaste tu contraseña?</h2>
                    <p class="text-gray-600">No te preocupes, te ayudaremos a recuperarla</p>
                </div>

                <div class="mb-4 text-sm text-gray-600">
                    {{ __('¿Olvidaste tu contraseña? No hay problema. Simplemente háznoslo saber tu dirección de correo electrónico y te enviaremos un enlace de restablecimiento de contraseña que te permitirá elegir una nueva.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

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
                                :value="old('email')" 
                                required 
                                autofocus
                                placeholder="tu@email.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <a 
                            class="text-sm text-prussian-blue hover:text-metallic-seaweed font-medium transition-colors" 
                            href="{{ route('login') }}"
                        >
                            {{ __('← Volver al inicio de sesión') }}
                        </a>

                        <x-primary-button class="bg-prussian-blue hover:bg-metallic-seaweed focus:ring-prussian-blue">
                            {{ __('Enviar Enlace') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
