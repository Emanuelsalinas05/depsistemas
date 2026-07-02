@php
    $worklog = $worklog ?? null;
    $tareas = $tareas ?? \App\Models\Tarea::orderBy('titulo')->get();
@endphp

<div class="grid grid-cols-1 gap-6">
    <!-- Tarea -->
    <div>
        <x-input-label for="tarea_id" value="Tarea *" />
        <select id="tarea_id" name="tarea_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
            <option value="">Seleccionar tarea...</option>
            @foreach($tareas as $tarea)
                <option value="{{ $tarea->id }}" {{ old('tarea_id', $worklog->tarea_id ?? request('tarea_id')) == $tarea->id ? 'selected' : '' }}>
                    {{ $tarea->titulo }} - {{ $tarea->proyecto->nombre }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('tarea_id')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Fecha -->
        <div>
            <x-input-label for="fecha" value="Fecha *" />
            <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full" 
                :value="old('fecha', $worklog->fecha ? $worklog->fecha->format('Y-m-d') : now()->format('Y-m-d'))" required />
            <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
        </div>

        <!-- Minutos -->
        <div>
            <x-input-label for="minutos" value="Minutos *" />
            <x-text-input id="minutos" name="minutos" type="number" min="1" max="1440" class="mt-1 block w-full" 
                :value="old('minutos', $worklog->minutos ?? '')" required />
            <p class="mt-1 text-sm text-gray-500">Máximo 1440 minutos (24 horas)</p>
            <x-input-error class="mt-2" :messages="$errors->get('minutos')" />
        </div>
    </div>

    <!-- Descripción -->
    <div>
        <x-input-label for="descripcion" value="Descripción" />
        <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('descripcion', $worklog->descripcion ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
    </div>

    <!-- Source -->
    <div>
        <x-input-label for="source" value="Origen *" />
        <select id="source" name="source" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
            <option value="manual" {{ old('source', $worklog->source ?? 'manual') === 'manual' ? 'selected' : '' }}>Manual</option>
            <option value="timer" {{ old('source', $worklog->source ?? '') === 'timer' ? 'selected' : '' }}>Timer</option>
            <option value="import" {{ old('source', $worklog->source ?? '') === 'import' ? 'selected' : '' }}>Importado</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('source')" />
    </div>
</div>
