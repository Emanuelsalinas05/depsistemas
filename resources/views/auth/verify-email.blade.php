<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-8">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-prussian-blue rounded-xl mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Verifica tu correo electrónico</h2>
                    <p class="text-gray-600">
                        Gracias por registrarte. Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte? Si no recibiste el correo, con gusto te enviaremos otro.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 p-4 bg-beau-blue/20 border border-beau-blue/30 rounded-lg">
                        <p class="text-sm text-prussian-blue">
                            {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.') }}
                        </p>
                    </div>
                @endif

                <div class="space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <x-primary-button class="w-full justify-center bg-prussian-blue hover:bg-metallic-seaweed focus:ring-prussian-blue py-3 rounded-lg">
                            {{ __('Reenviar correo de verificación') }}
                        </x-primary-button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-sm text-gray-600 hover:text-gray-900 font-medium py-2">
                            {{ __('Cerrar Sesión') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
