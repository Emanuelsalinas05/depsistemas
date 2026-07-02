@php
    $acuerdo = $acuerdo ?? null;
    $reuniones = $reuniones ?? \App\Models\Reunion::orderBy('fecha_inicio', 'desc')->get();
    $proyectos = $proyectos ?? \App\Models\Proyecto::orderBy('nombre')->get();
    $usuarios = $usuarios ?? \App\Models\User::orderBy('name')->get();
@endphp

<div class="grid grid-cols-1 gap-6">
    <!-- Título -->
    <div>
        <x-input-label for="titulo" value="Título *" />
        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo', $acuerdo->titulo ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
    </div>

    <!-- Detalle -->
    <div>
        <x-input-label for="detalle" value="Detalle" />
        <textarea id="detalle" name="detalle" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('detalle', $acuerdo->detalle ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('detalle')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Reunión -->
        <div>
            <x-input-label for="reunion_id" value="Reunión" />
            <select id="reunion_id" name="reunion_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                <option value="">Sin reunión</option>
                @foreach($reuniones as $reunion)
                    <option value="{{ $reunion->id }}" {{ old('reunion_id', $acuerdo->reunion_id ?? request('reunion_id')) == $reunion->id ? 'selected' : '' }}>
                        {{ $reunion->titulo }} - {{ $reunion->fecha_inicio->format('d/m/Y') }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('reunion_id')" />
        </div>

        <!-- Proyecto -->
        <div>
            <x-input-label for="proyecto_id" value="Proyecto" />
            <select id="proyecto_id" name="proyecto_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                <option value="">Sin proyecto</option>
                @foreach($proyectos as $proyecto)
                    <option value="{{ $proyecto->id }}" {{ old('proyecto_id', $acuerdo->proyecto_id ?? request('proyecto_id')) == $proyecto->id ? 'selected' : '' }}>
                        {{ $proyecto->nombre }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('proyecto_id')" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Responsable -->
        <div>
            <x-input-label for="responsable_id" value="Responsable" />
            <select id="responsable_id" name="responsable_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                <option value="">Sin responsable</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('responsable_id', $acuerdo->responsable_id ?? '') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('responsable_id')" />
        </div>

        <!-- Fecha Compromiso -->
        <div>
            <x-input-label for="fecha_compromiso" value="Fecha de Compromiso" />
            <x-text-input id="fecha_compromiso" name="fecha_compromiso" type="date" class="mt-1 block w-full" 
                :value="old('fecha_compromiso', $acuerdo->fecha_compromiso ? $acuerdo->fecha_compromiso->format('Y-m-d') : '')" />
            <x-input-error class="mt-2" :messages="$errors->get('fecha_compromiso')" />
        </div>
    </div>

    <!-- Estatus -->
    <div>
        <x-input-label for="estatus" value="Estatus *" />
        <select id="estatus" name="estatus" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
            <option value="pendiente" {{ old('estatus', $acuerdo->estatus ?? 'pendiente') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="en_progreso" {{ old('estatus', $acuerdo->estatus ?? '') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
            <option value="cumplido" {{ old('estatus', $acuerdo->estatus ?? '') === 'cumplido' ? 'selected' : '' }}>Cumplido</option>
            <option value="cancelado" {{ old('estatus', $acuerdo->estatus ?? '') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('estatus')" />
    </div>
</div>
