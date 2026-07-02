<x-guest-layout>
    <div class="min-h-screen lg:grid lg:grid-cols-2 bg-slate-100">
        <aside class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-prussian-blue via-metallic-seaweed to-prussian-blue">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.18),transparent_40%),radial-gradient(circle_at_80%_80%,rgba(191,215,234,0.20),transparent_42%)]"></div>

            <div class="relative z-10 flex w-full flex-col justify-center px-14 py-16 text-white">
                <p class="inline-flex w-fit rounded-full border border-white/30 bg-white/10 px-4 py-1 text-xs tracking-wide uppercase">Solicitud Institucional</p>
                <h1 class="mt-6 text-5xl font-bold leading-tight">Registro de Usuario</h1>
                <p class="mt-4 max-w-xl text-lg text-beau-blue/90 leading-relaxed">
                    Complete el formulario para solicitar habilitacion al sistema. La aprobacion se realiza conforme a politicas institucionales de acceso.
                </p>

                <ul class="mt-10 space-y-3 max-w-lg">
                    <li class="flex items-center gap-3 rounded-xl border border-white/25 bg-white/10 p-3 backdrop-blur-sm">
                        <svg class="h-5 w-5 text-beau-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Flujo de acceso trazable y auditable
                    </li>
                    <li class="flex items-center gap-3 rounded-xl border border-white/25 bg-white/10 p-3 backdrop-blur-sm">
                        <svg class="h-5 w-5 text-beau-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Asignacion de roles y permisos por politica RBAC
                    </li>
                    <li class="flex items-center gap-3 rounded-xl border border-white/25 bg-white/10 p-3 backdrop-blur-sm">
                        <svg class="h-5 w-5 text-beau-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Integracion con operaciones del departamento
                    </li>
                </ul>
            </div>
        </aside>

        <section class="flex items-center justify-center px-6 py-10 sm:px-10">
            <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white shadow-xl shadow-slate-200/60">
                <div class="p-8 sm:p-10">
                    <div class="text-center">
                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-xl bg-prussian-blue text-white shadow-lg shadow-prussian-blue/20">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </span>
                        <h2 class="mt-5 text-3xl font-bold text-slate-900">Solicitud de Acceso</h2>
                        <p class="mt-2 text-sm text-slate-600">Complete los datos requeridos</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nombre')" class="text-slate-700" />
                            <div class="mt-2 relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <x-text-input id="name" class="block w-full pl-10 rounded-lg border-slate-300 focus:border-prussian-blue focus:ring-prussian-blue" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nombre completo" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Correo Electronico')" class="text-slate-700" />
                            <div class="mt-2 relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                </div>
                                <x-text-input id="email" class="block w-full pl-10 rounded-lg border-slate-300 focus:border-prussian-blue focus:ring-prussian-blue" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="usuario@institucion.gob" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Contrasena')" class="text-slate-700" />
                            <div class="mt-2 relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <x-text-input id="password" class="block w-full pl-10 rounded-lg border-slate-300 focus:border-prussian-blue focus:ring-prussian-blue" type="password" name="password" required autocomplete="new-password" placeholder="********" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar Contrasena')" class="text-slate-700" />
                            <div class="mt-2 relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <x-text-input id="password_confirmation" class="block w-full pl-10 rounded-lg border-slate-300 focus:border-prussian-blue focus:ring-prussian-blue" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="********" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <label for="terms" class="inline-flex items-start gap-3 text-sm text-slate-600">
                            <input id="terms" type="checkbox" class="mt-0.5 rounded border-slate-300 text-prussian-blue focus:ring-prussian-blue" required>
                            <span>Acepto las <a href="#" class="font-medium text-prussian-blue hover:text-metallic-seaweed">politicas institucionales</a> y los terminos de uso.</span>
                        </label>

                        <x-primary-button class="w-full justify-center rounded-lg py-3 text-sm font-semibold uppercase tracking-wide bg-prussian-blue hover:bg-metallic-seaweed focus:ring-prussian-blue">
                            {{ __('Solicitar Acceso') }}
                        </x-primary-button>
                    </form>

                    <p class="mt-6 text-center text-sm text-slate-600">
                        Ya posee una cuenta de usuario?
                        <a href="{{ route('login') }}" class="font-semibold text-prussian-blue hover:text-metallic-seaweed">{{ __('Acceder al Sistema') }}</a>
                    </p>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
