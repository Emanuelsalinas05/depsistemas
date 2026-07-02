<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema de Gestion de Desarrollos') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
@php
    $capacidades = [
        [
            'titulo' => 'Alinea el trabajo con los objetivos',
            'texto' => 'Relaciona tareas, proyectos y releases con metas institucionales para facilitar seguimiento y rendicion de cuentas.',
            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        ],
        [
            'titulo' => 'Planifica y asigna la actividad',
            'texto' => 'Organiza cronogramas, responsables y dependencias con una planificacion clara por proyecto.',
            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        [
            'titulo' => 'Obten una vision general',
            'texto' => 'Consolida estado operativo, prioridades y riesgos en un tablero ejecutivo de referencia diaria.',
            'icon' => 'M3 7h18M3 12h18M3 17h18',
        ],
        [
            'titulo' => 'Prioriza las tareas segun el contexto',
            'texto' => 'Ordena trabajo segun criticidad, dependencias, fecha compromiso y capacidad del equipo.',
            'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
        ],
        [
            'titulo' => 'Mas colaboracion y menos distracciones',
            'texto' => 'Centraliza comentarios, acuerdos, seguimiento y evidencia operativa en un mismo flujo.',
            'icon' => 'M17 20h5v-2a3 3 0 00-5.36-1.86M17 20H7m10 0v-2c0-.65-.13-1.28-.36-1.86M7 20H2v-2a3 3 0 015.36-1.86M7 20v-2c0-.65.13-1.28.36-1.86m0 0a5 5 0 019.29 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
        ],
        [
            'titulo' => 'Automatizacion',
            'texto' => 'Reduce tareas manuales mediante plantillas y automatismos para acelerar la ejecucion del equipo.',
            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
        ],
    ];

    $metricas = [
        [
            'titulo' => 'Frecuencia de implementacion',
            'texto' => 'Velocidad de despliegues y releases por periodo.',
            'icon' => 'M4 13h4v7H4v-7zm6-6h4v13h-4V7zm6 3h4v10h-4V10z',
        ],
        [
            'titulo' => 'Duracion de ciclos',
            'texto' => 'Tiempo desde creacion hasta cierre de tareas.',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'titulo' => 'Carga de trabajo',
            'texto' => 'Distribucion de esfuerzo por persona y proyecto.',
            'icon' => 'M9 17v-2a4 4 0 014-4h8M3 17v-2a4 4 0 014-4h4M9 7a4 4 0 11-8 0 4 4 0 018 0m14 2a4 4 0 11-8 0 4 4 0 018 0',
        ],
    ];

    $funciones = [
        ['funcion' => 'Planificacion agil', 'que' => 'Crear historias de usuario, incidencias y planificar sprints', 'beneficio' => 'Orden y visibilidad del backlog institucional'],
        ['funcion' => 'Gestion de tareas/incidencias', 'que' => 'Asignar, priorizar y dar seguimiento a tareas y bugs', 'beneficio' => 'Control operativo de compromisos por responsable'],
        ['funcion' => 'Estimacion de proyectos', 'que' => 'Gestionar estimaciones por tiempo y esfuerzo', 'beneficio' => 'Mejor precision de planificacion y entregas'],
        ['funcion' => 'Gestion del backlog', 'que' => 'Clasificar, ordenar y depurar pendientes', 'beneficio' => 'Ejecucion enfocada con menor saturacion'],
        ['funcion' => 'Tableros Kanban/Scrum', 'que' => 'Visualizar flujo de trabajo en tiempo real', 'beneficio' => 'Seguimiento transparente del avance'],
        ['funcion' => 'Reportes y metricas', 'que' => 'Generar indicadores operativos y de desempeno', 'beneficio' => 'Decisiones basadas en evidencia'],
    ];

    $integraciones = [
        [
            'nombre' => 'GitHub',
            'texto' => 'Sincronizacion de repositorios, webhooks y trazabilidad de cambios.',
            'icon' => 'M12 2a10 10 0 00-3.16 19.49c.5.09.68-.22.68-.48v-1.68c-2.78.61-3.37-1.2-3.37-1.2-.46-1.15-1.11-1.46-1.11-1.46-.9-.6.07-.58.07-.58 1 .07 1.52 1.01 1.52 1.01.88 1.48 2.32 1.05 2.88.81.09-.62.35-1.05.64-1.29-2.22-.25-4.55-1.08-4.55-4.83 0-1.07.39-1.95 1.03-2.64-.11-.25-.45-1.28.1-2.66 0 0 .84-.26 2.75 1.01A9.74 9.74 0 0112 6.84c.86 0 1.72.12 2.53.35 1.91-1.27 2.75-1.01 2.75-1.01.55 1.38.21 2.41.1 2.66.64.69 1.03 1.57 1.03 2.64 0 3.76-2.34 4.58-4.57 4.83.36.31.68.9.68 1.82v2.7c0 .27.18.58.69.48A10 10 0 0012 2z',
        ],
        [
            'nombre' => 'Google Calendar',
            'texto' => 'Agenda institucional de reuniones y eventos vinculados al trabajo operativo.',
            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        [
            'nombre' => 'Correo Electronico',
            'texto' => 'Notificaciones, recordatorios y comunicaciones automatizadas.',
            'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-16 11h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        ],
        [
            'nombre' => 'Google Drive',
            'texto' => 'Gestion documental y sincronizacion de evidencias de trabajo.',
            'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
        ],
    ];
@endphp

<div class="min-h-screen flex flex-col">
    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-prussian-blue to-metallic-seaweed text-white shadow-md">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-900">Sistema de Gestion de Desarrollos</p>
                    <p class="text-xs text-slate-500">Departamento de Desarrollo de Sistemas</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-prussian-blue hover:bg-slate-100">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Iniciar sesion</a>
                    @if (Route::has('register') && !config('app.disable_registration'))
                        <a href="{{ route('register') }}" class="rounded-lg bg-prussian-blue px-4 py-2 text-sm font-semibold text-white hover:bg-metallic-seaweed">Solicitar acceso</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        <section class="relative overflow-hidden bg-gradient-to-br from-prussian-blue via-metallic-seaweed to-prussian-blue text-white">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_10%_20%,rgba(255,255,255,.24),transparent_40%),radial-gradient(circle_at_85%_80%,rgba(191,215,234,.24),transparent_45%)]"></div>
            <div class="relative mx-auto grid max-w-7xl items-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
                <div>
                    <p class="inline-flex rounded-full border border-white/30 bg-white/10 px-4 py-1 text-xs uppercase tracking-wide">Plataforma institucional</p>
                    <h1 class="mt-6 text-4xl font-extrabold leading-tight sm:text-5xl">Gestion Integral de Proyectos y Desarrollos</h1>
                    <p class="mt-5 max-w-2xl text-lg leading-relaxed text-beau-blue/95">
                        Solucion institucional para administrar sistemas, proyectos, tareas, documentacion, reuniones y acuerdos del Departamento de Desarrollo de Sistemas, Direccion de Informatica y Telecomunicaciones.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-lg bg-white px-5 py-3 text-sm font-bold uppercase tracking-wide text-prussian-blue hover:bg-beau-blue">Ir al dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg bg-white px-5 py-3 text-sm font-bold uppercase tracking-wide text-prussian-blue hover:bg-beau-blue">Iniciar sesion</a>
                            @if (Route::has('register') && !config('app.disable_registration'))
                                <a href="{{ route('register') }}" class="rounded-lg border border-white/40 bg-white/10 px-5 py-3 text-sm font-bold uppercase tracking-wide text-white hover:bg-white/20">Solicitar acceso</a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-white/25 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-wide text-beau-blue/80">Cobertura operativa</p>
                        <p class="mt-2 text-3xl font-bold">End-to-end</p>
                        <p class="mt-1 text-sm text-beau-blue/90">Desde planificacion hasta cierre y trazabilidad.</p>
                    </div>
                    <div class="rounded-xl border border-white/25 bg-white/10 p-5 backdrop-blur-sm">
                        <p class="text-xs uppercase tracking-wide text-beau-blue/80">Gobierno y control</p>
                        <p class="mt-2 text-3xl font-bold">RBAC</p>
                        <p class="mt-1 text-sm text-beau-blue/90">Permisos por rol global y rol de proyecto.</p>
                    </div>
                    <div class="rounded-xl border border-white/25 bg-white/10 p-5 backdrop-blur-sm sm:col-span-2">
                        <p class="text-xs uppercase tracking-wide text-beau-blue/80">Disponibilidad de informacion</p>
                        <p class="mt-2 text-2xl font-bold">Metricas, reportes y evidencia centralizada</p>
                        <p class="mt-1 text-sm text-beau-blue/90">Datos operativos accesibles para decisiones con contexto.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-bold text-slate-900">Capacidades Principales</h2>
                <p class="mt-2 text-slate-600">Experiencia institucional enfocada en productividad y control operativo.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($capacidades as $item)
                    <article class="group rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                        <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-lg bg-prussian-blue/10 text-prussian-blue">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $item['titulo'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $item['texto'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-gradient-to-br from-prussian-blue via-metallic-seaweed to-prussian-blue p-8 text-white shadow-xl sm:p-10">
                <h2 class="text-3xl font-bold">Informacion y Metricas</h2>
                <p class="mt-3 max-w-3xl text-beau-blue/95">
                    Las funciones analiticas e informes listos para uso permiten medir frecuencia de implementacion, duracion de ciclos y distribucion de carga de trabajo.
                </p>

                <div class="mt-7 grid gap-4 md:grid-cols-3">
                    @foreach ($metricas as $metrica)
                        <article class="rounded-xl border border-white/25 bg-white/10 p-4 backdrop-blur-sm">
                            <div class="mb-2 inline-flex h-9 w-9 items-center justify-center rounded-md bg-white/20 text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metrica['icon'] }}" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold">{{ $metrica['titulo'] }}</p>
                            <p class="mt-1 text-sm text-beau-blue/90">{{ $metrica['texto'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-slate-900">Funcionalidades del Sistema</h2>
                <p class="mt-2 text-slate-600">Alcance operativo para gestion diaria del ciclo de desarrollo.</p>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-100">Funcion</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-100">Que permite</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-100">Beneficio</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($funciones as $fila)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $fila['funcion'] }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $fila['que'] }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $fila['beneficio'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold text-slate-900">Integraciones Disponibles</h2>
                <p class="mt-2 text-slate-600">Conectividad con herramientas de uso frecuente del equipo.</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($integraciones as $integracion)
                    <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                        <div class="mb-4 inline-flex h-11 w-11 items-center justify-center rounded-lg bg-prussian-blue/10 text-prussian-blue">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $integracion['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $integracion['nombre'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $integracion['texto'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 text-center sm:px-6 lg:px-8">
            <p class="text-sm font-medium text-slate-700">Sistema de Gestion de Desarrollos</p>
            <p class="mt-1 text-xs text-slate-500">Departamento de Desarrollo de Sistemas, Direccion de Informatica y Telecomunicaciones</p>
            <p class="mt-2 text-xs text-slate-400">Powered by Laravel {{ app()->version() }}</p>
        </div>
    </footer>
</div>
</body>
</html>
