<x-guest-layout>
    <div class="min-h-screen lg:grid lg:grid-cols-2 bg-slate-100">
        <aside class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-prussian-blue via-metallic-seaweed to-prussian-blue">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_15%_20%,rgba(255,255,255,0.18),transparent_40%),radial-gradient(circle_at_85%_85%,rgba(191,215,234,0.20),transparent_42%)]"></div>

            <div class="relative z-10 flex w-full flex-col justify-center px-14 py-16 text-white">
                <p class="inline-flex w-fit rounded-full border border-white/30 bg-white/10 px-4 py-1 text-xs tracking-wide uppercase">Acceso Institucional</p>
                <h1 class="mt-6 text-5xl font-bold leading-tight">Sistema de Gestion de Desarrollos</h1>
                <p class="mt-4 max-w-xl text-lg text-beau-blue/90 leading-relaxed">
                    Plataforma institucional para la coordinacion de proyectos, tareas, documentacion y seguimiento operativo del Departamento de Desarrollo de Sistemas.
                </p>

                <dl class="mt-10 grid grid-cols-2 gap-4 max-w-lg">
                    <div class="rounded-xl border border-white/25 bg-white/10 p-4 backdrop-blur-sm">
                        <dt class="text-xs text-beau-blue/80 uppercase tracking-wide">Control</dt>
                        <dd class="mt-1 text-2xl font-semibold">100%</dd>
                        <p class="text-sm text-beau-blue/80">Trazabilidad de acciones</p>
                    </div>
                    <div class="rounded-xl border border-white/25 bg-white/10 p-4 backdrop-blur-sm">
                        <dt class="text-xs text-beau-blue/80 uppercase tracking-wide">Disponibilidad</dt>
                        <dd class="mt-1 text-2xl font-semibold">24/7</dd>
                        <p class="text-sm text-beau-blue/80">Operacion continua</p>
                    </div>
                </dl>
            </div>
        </aside>

        <section class="flex items-center justify-center px-6 py-10 sm:px-10">
            <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-xl shadow-slate-200/60">
                <div class="p-8 sm:p-10">
                    <div class="text-center">
                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl bg-prussian-blue text-white shadow-lg shadow-prussian-blue/20">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </span>
                        <h2 class="mt-5 text-3xl font-bold text-slate-900">Acceso al Sistema</h2>
                        <p class="mt-2 text-sm text-slate-600">Ingrese sus credenciales institucionales</p>
                    </div>

                    <x-auth-session-status class="mt-6" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="email" :value="__('Correo Electronico')" class="text-slate-700" />
                            <div class="mt-2 relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <x-text-input id="email" class="block w-full pl-10 rounded-lg border-slate-300 focus:border-prussian-blue focus:ring-prussian-blue" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="usuario@institucion.gob" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Contrasena')" class="text-slate-700" />
                            <div class="mt-2 relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <x-text-input id="password" class="block w-full pl-10 rounded-lg border-slate-300 focus:border-prussian-blue focus:ring-prussian-blue" type="password" name="password" required autocomplete="current-password" placeholder="********" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <label for="remember_me" class="inline-flex items-center text-sm text-slate-600">
                                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-prussian-blue focus:ring-prussian-blue" name="remember">
                                <span class="ms-2">{{ __('Recordarme') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-prussian-blue hover:text-metallic-seaweed" href="{{ route('password.request') }}">
                                    {{ __('Olvido su contrasena?') }}
                                </a>
                            @endif
                        </div>

                        <x-primary-button class="w-full justify-center rounded-lg py-3 text-sm font-semibold uppercase tracking-wide bg-prussian-blue hover:bg-metallic-seaweed focus:ring-prussian-blue">
                            {{ __('Ingresar') }}
                        </x-primary-button>
                    </form>

                    @if (Route::has('register') && !config('app.disable_registration'))
                        <p class="mt-6 text-center text-sm text-slate-600">
                            No posee una cuenta de usuario?
                            <a href="{{ route('register') }}" class="font-semibold text-prussian-blue hover:text-metallic-seaweed">{{ __('Solicitar acceso') }}</a>
                        </p>
                    @endif
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
