@php
    $tarea = $tarea ?? null;
    $proyectos = $proyectos ?? \App\Models\Proyecto::orderBy('nombre')->get();
    $usuarios = $usuarios ?? \App\Models\User::orderBy('name')->get();
@endphp

<div class="grid grid-cols-1 gap-6">
    <!-- Proyecto -->
    <div>
        <x-input-label for="proyecto_id" value="Proyecto *" />
        <select id="proyecto_id" name="proyecto_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
            <option value="">Seleccionar proyecto...</option>
            @foreach($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}" {{ old('proyecto_id', $tarea->proyecto_id ?? request('proyecto_id')) == $proyecto->id ? 'selected' : '' }}>
                    {{ $proyecto->nombre }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('proyecto_id')" />
    </div>

    <!-- Título -->
    <div>
        <x-input-label for="titulo" value="Título *" />
        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo', $tarea->titulo ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
    </div>

    <!-- Descripción -->
    <div>
        <x-input-label for="descripcion" value="Descripción" />
        <textarea id="descripcion" name="descripcion" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('descripcion', $tarea->descripcion ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Tipo -->
        <div>
            <x-input-label for="tipo" value="Tipo *" />
            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="feature" {{ old('tipo', $tarea->tipo ?? 'feature') === 'feature' ? 'selected' : '' }}>Feature</option>
                <option value="bug" {{ old('tipo', $tarea->tipo ?? '') === 'bug' ? 'selected' : '' }}>Bug</option>
                <option value="soporte" {{ old('tipo', $tarea->tipo ?? '') === 'soporte' ? 'selected' : '' }}>Soporte</option>
                <option value="mejora" {{ old('tipo', $tarea->tipo ?? '') === 'mejora' ? 'selected' : '' }}>Mejora</option>
                <option value="doc" {{ old('tipo', $tarea->tipo ?? '') === 'doc' ? 'selected' : '' }}>Documentación</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
        </div>

        <!-- Prioridad -->
        <div>
            <x-input-label for="prioridad" value="Prioridad *" />
            <select id="prioridad" name="prioridad" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="alta" {{ old('prioridad', $tarea->prioridad ?? 'media') === 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="media" {{ old('prioridad', $tarea->prioridad ?? 'media') === 'media' ? 'selected' : '' }}>Media</option>
                <option value="baja" {{ old('prioridad', $tarea->prioridad ?? 'media') === 'baja' ? 'selected' : '' }}>Baja</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('prioridad')" />
        </div>

        <!-- Estado -->
        <div>
            <x-input-label for="estado" value="Estado *" />
            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="nuevo" {{ old('estado', $tarea->estado ?? 'nuevo') === 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                <option value="en_curso" {{ old('estado', $tarea->estado ?? '') === 'en_curso' ? 'selected' : '' }}>En Curso</option>
                <option value="en_revision" {{ old('estado', $tarea->estado ?? '') === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                <option value="listo_release" {{ old('estado', $tarea->estado ?? '') === 'listo_release' ? 'selected' : '' }}>Listo Release</option>
                <option value="cerrado" {{ old('estado', $tarea->estado ?? '') === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('estado')" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Asignado a -->
        <div>
            <x-input-label for="asignado_a" value="Asignado a" />
            <select id="asignado_a" name="asignado_a" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                <option value="">Sin asignar</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('asignado_a', $tarea->asignado_a ?? '') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('asignado_a')" />
        </div>

        <!-- Estimación Horas -->
        <div>
            <x-input-label for="estimacion_horas" value="Estimación (horas)" />
            <x-text-input id="estimacion_horas" name="estimacion_horas" type="number" step="0.5" min="0" class="mt-1 block w-full" :value="old('estimacion_horas', $tarea->estimacion_horas ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('estimacion_horas')" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Fecha Inicio -->
        <div>
            <x-input-label for="fecha_inicio" value="Fecha de Inicio" />
            <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full" :value="old('fecha_inicio', $tarea->fecha_inicio ? $tarea->fecha_inicio->format('Y-m-d') : '')" />
            <x-input-error class="mt-2" :messages="$errors->get('fecha_inicio')" />
        </div>

        <!-- Fecha Fin -->
        <div>
            <x-input-label for="fecha_fin" value="Fecha de Fin" />
            <x-text-input id="fecha_fin" name="fecha_fin" type="date" class="mt-1 block w-full" :value="old('fecha_fin', $tarea->fecha_fin ? $tarea->fecha_fin->format('Y-m-d') : '')" />
            <x-input-error class="mt-2" :messages="$errors->get('fecha_fin')" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Progreso -->
        <div>
            <x-input-label for="progreso" value="Progreso (%)" />
            <x-text-input id="progreso" name="progreso" type="number" min="0" max="100" class="mt-1 block w-full" :value="old('progreso', $tarea->progreso ?? 0)" />
            <x-input-error class="mt-2" :messages="$errors->get('progreso')" />
        </div>

        <!-- Evidencia URL -->
        <div>
            <x-input-label for="evidencia_url" value="URL Evidencia (PR/Commit)" />
            <x-text-input id="evidencia_url" name="evidencia_url" type="url" class="mt-1 block w-full" :value="old('evidencia_url', $tarea->evidencia_url ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('evidencia_url')" />
        </div>
    </div>
</div>
