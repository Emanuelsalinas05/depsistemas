@php
    $reunion = $reunion ?? null;
    $proyectos = $proyectos ?? \App\Models\Proyecto::orderBy('nombre')->get();
    $usuarios = $usuarios ?? \App\Models\User::orderBy('name')->get();
@endphp

<div class="grid grid-cols-1 gap-6">
    <!-- Título -->
    <div>
        <x-input-label for="titulo" value="Título *" />
        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo', $reunion->titulo ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
    </div>

    <!-- Proyecto -->
    <div>
        <x-input-label for="proyecto_id" value="Proyecto" />
        <select id="proyecto_id" name="proyecto_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
            <option value="">Sin proyecto</option>
            @foreach($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}" {{ old('proyecto_id', $reunion->proyecto_id ?? request('proyecto_id')) == $proyecto->id ? 'selected' : '' }}>
                    {{ $proyecto->nombre }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('proyecto_id')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Fecha Inicio -->
        <div>
            <x-input-label for="fecha_inicio" value="Fecha y Hora de Inicio *" />
            <x-text-input id="fecha_inicio" name="fecha_inicio" type="datetime-local" class="mt-1 block w-full" 
                :value="old('fecha_inicio', $reunion->fecha_inicio ? $reunion->fecha_inicio->format('Y-m-d\TH:i') : '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('fecha_inicio')" />
        </div>

        <!-- Fecha Fin -->
        <div>
            <x-input-label for="fecha_fin" value="Fecha y Hora de Fin" />
            <x-text-input id="fecha_fin" name="fecha_fin" type="datetime-local" class="mt-1 block w-full" 
                :value="old('fecha_fin', $reunion->fecha_fin ? $reunion->fecha_fin->format('Y-m-d\TH:i') : '')" />
            <x-input-error class="mt-2" :messages="$errors->get('fecha_fin')" />
        </div>
    </div>

    <!-- Ubicación -->
    <div>
        <x-input-label for="ubicacion" value="Ubicación" />
        <x-text-input id="ubicacion" name="ubicacion" type="text" class="mt-1 block w-full" :value="old('ubicacion', $reunion->ubicacion ?? '')" placeholder="Sala, Zoom, etc." />
        <x-input-error class="mt-2" :messages="$errors->get('ubicacion')" />
    </div>

    <!-- Descripción -->
    <div>
        <x-input-label for="descripcion" value="Descripción" />
        <textarea id="descripcion" name="descripcion" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('descripcion', $reunion->descripcion ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
    </div>

    <!-- Asistentes -->
    <div>
        <x-input-label value="Asistentes" />
        <div class="mt-2 space-y-2" id="asistentes-container">
            @if(old('asistentes'))
                @foreach(old('asistentes') as $index => $asistente)
                    <div class="flex gap-2 items-center">
                        <select name="asistentes[{{ $index }}][tipo]" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="interno" {{ $asistente['tipo'] === 'interno' ? 'selected' : '' }}>Interno</option>
                            <option value="externo" {{ $asistente['tipo'] === 'externo' ? 'selected' : '' }}>Externo</option>
                        </select>
                        <select name="asistentes[{{ $index }}][user_id]" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Seleccionar usuario...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ ($asistente['user_id'] ?? '') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-text-input name="asistentes[{{ $index }}][nombre_externo]" type="text" placeholder="Nombre externo" class="flex-1" :value="$asistente['nombre_externo'] ?? ''" />
                        <x-text-input name="asistentes[{{ $index }}][email_externo]" type="email" placeholder="Email externo" class="flex-1" :value="$asistente['email_externo'] ?? ''" />
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">✕</button>
                    </div>
                @endforeach
            @elseif($reunion && $reunion->asistentes->count() > 0)
                @foreach($reunion->asistentes as $index => $asistente)
                    <div class="flex gap-2 items-center">
                        <select name="asistentes[{{ $index }}][tipo]" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="interno" {{ $asistente->user_id ? 'selected' : '' }}>Interno</option>
                            <option value="externo" {{ !$asistente->user_id ? 'selected' : '' }}>Externo</option>
                        </select>
                        <select name="asistentes[{{ $index }}][user_id]" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Seleccionar usuario...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $asistente->user_id == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-text-input name="asistentes[{{ $index }}][nombre_externo]" type="text" placeholder="Nombre externo" class="flex-1" :value="$asistente->nombre_externo ?? ''" />
                        <x-text-input name="asistentes[{{ $index }}][email_externo]" type="email" placeholder="Email externo" class="flex-1" :value="$asistente->email_externo ?? ''" />
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">✕</button>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="button" onclick="agregarAsistente()" class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Agregar Asistente</button>
    </div>
</div>

<script>
let asistenteIndex = @json(old('asistentes') ? count(old('asistentes')) : ($reunion && $reunion->asistentes ? $reunion->asistentes->count() : 0));

function agregarAsistente() {
    const container = document.getElementById('asistentes-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 items-center';
    div.innerHTML = `
        <select name="asistentes[${asistenteIndex}][tipo]" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
            <option value="interno">Interno</option>
            <option value="externo">Externo</option>
        </select>
        <select name="asistentes[${asistenteIndex}][user_id]" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
            <option value="">Seleccionar usuario...</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
            @endforeach
        </select>
        <input type="text" name="asistentes[${asistenteIndex}][nombre_externo]" placeholder="Nombre externo" class="flex-1 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
        <input type="email" name="asistentes[${asistenteIndex}][email_externo]" placeholder="Email externo" class="flex-1 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
        <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">✕</button>
    `;
    container.appendChild(div);
    asistenteIndex++;
}
</script>
