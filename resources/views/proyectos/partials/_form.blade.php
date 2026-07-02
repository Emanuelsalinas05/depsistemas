@php
    $proyecto = $proyecto ?? null;
    $sistemas = $sistemas ?? \App\Models\Sistema::orderBy('nombre')->get();
@endphp

<div class="grid grid-cols-1 gap-6">
    <!-- Nombre -->
    <div>
        <x-input-label for="nombre" value="Nombre *" />
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $proyecto->nombre ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
    </div>

    <!-- Sistema -->
    <div>
        <x-input-label for="sistema_id" value="Sistema" />
        <select id="sistema_id" name="sistema_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
            <option value="">Sin sistema</option>
            @foreach($sistemas as $sistema)
                <option value="{{ $sistema->id }}" {{ old('sistema_id', $proyecto->sistema_id ?? '') == $sistema->id ? 'selected' : '' }}>
                    {{ $sistema->nombre }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('sistema_id')" />
    </div>

    <!-- Objetivo -->
    <div>
        <x-input-label for="objetivo" value="Objetivo" />
        <textarea id="objetivo" name="objetivo" rows="3" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('objetivo', $proyecto->objetivo ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('objetivo')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Fecha Inicio -->
        <div>
            <x-input-label for="fecha_inicio" value="Fecha de Inicio" />
            <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full" :value="old('fecha_inicio', $proyecto->fecha_inicio ? $proyecto->fecha_inicio->format('Y-m-d') : '')" />
            <x-input-error class="mt-2" :messages="$errors->get('fecha_inicio')" />
        </div>

        <!-- Fecha Fin -->
        <div>
            <x-input-label for="fecha_fin" value="Fecha de Fin" />
            <x-text-input id="fecha_fin" name="fecha_fin" type="date" class="mt-1 block w-full" :value="old('fecha_fin', $proyecto->fecha_fin ? $proyecto->fecha_fin->format('Y-m-d') : '')" />
            <x-input-error class="mt-2" :messages="$errors->get('fecha_fin')" />
        </div>
    </div>

    <!-- Estatus -->
    <div>
        <x-input-label for="estatus" value="Estatus *" />
        <select id="estatus" name="estatus" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
            <option value="planeado" {{ old('estatus', $proyecto->estatus ?? 'planeado') === 'planeado' ? 'selected' : '' }}>Planeado</option>
            <option value="en_progreso" {{ old('estatus', $proyecto->estatus ?? '') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
            <option value="en_pausa" {{ old('estatus', $proyecto->estatus ?? '') === 'en_pausa' ? 'selected' : '' }}>En Pausa</option>
            <option value="cerrado" {{ old('estatus', $proyecto->estatus ?? '') === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('estatus')" />
    </div>
</div>
