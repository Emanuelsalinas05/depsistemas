@php
    $isMobile = isset($isMobile) ? $isMobile : false;
@endphp

<div class="flex flex-col {{ $isMobile ? 'w-full' : 'w-64' }}">
    <!-- Sidebar -->
    <div class="flex flex-col flex-grow bg-prussian-blue pt-5 pb-4 overflow-y-auto">
        <!-- Logo -->
        <div class="flex items-center flex-shrink-0 px-6 mb-8">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <div class="flex-shrink-0 w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-prussian-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                    </svg>
                </div>
                <span class="ml-3 text-white text-lg font-semibold">Sistema Gestión</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-metallic-seaweed text-white' : 'text-beau-blue hover:bg-white/10 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            @can('sistemas.viewAny')
            <a href="{{ route('sistemas.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('sistemas.*') ? 'bg-metallic-seaweed text-white' : 'text-beau-blue hover:bg-white/10 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                </svg>
                Sistemas
            </a>
            @endcan

            @can('proyectos.viewAny')
            <a href="{{ route('proyectos.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('proyectos.*') ? 'bg-metallic-seaweed text-white' : 'text-beau-blue hover:bg-white/10 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Proyectos
            </a>
            @endcan

            @can('tareas.viewAny')
            <a href="{{ route('tareas.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('tareas.*') ? 'bg-metallic-seaweed text-white' : 'text-beau-blue hover:bg-white/10 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Tareas
            </a>
            @endcan

            @can('docs.viewAny')
            <a href="{{ route('documentos.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('documentos.*') ? 'bg-metallic-seaweed text-white' : 'text-beau-blue hover:bg-white/10 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Documentos
            </a>
            @endcan

            @can('reuniones.viewAny')
            <a href="{{ route('reuniones.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('reuniones.*') ? 'bg-metallic-seaweed text-white' : 'text-beau-blue hover:bg-white/10 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Reuniones
            </a>
            @endcan

            @can('worklogs.viewAny')
            <a href="{{ route('worklogs.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('worklogs.*') ? 'bg-metallic-seaweed text-white' : 'text-beau-blue hover:bg-white/10 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Worklogs
            </a>
            @endcan

            @can('reportes.view')
            <a href="{{ route('reportes.index') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('reportes.*') ? 'bg-metallic-seaweed text-white' : 'text-beau-blue hover:bg-white/10 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Reportes
            </a>
            @endcan
        </nav>

        <!-- User Section -->
        <div class="flex-shrink-0 flex border-t border-white/20 p-4">
            <div class="flex-shrink-0 w-full group block">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-metallic-seaweed flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-beau-blue/80">{{ Auth::user()->roles->first()?->name ?? 'Usuario' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
