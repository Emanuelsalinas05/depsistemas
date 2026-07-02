@php
    $documento = $documento ?? null;
    $sistemas = $sistemas ?? \App\Models\Sistema::orderBy('nombre')->get();
    $releases = $releases ?? collect();
@endphp

<div class="grid grid-cols-1 gap-6">
    <!-- Sistema -->
    <div>
        <x-input-label for="sistema_id" value="Sistema *" />
        <select id="sistema_id" name="sistema_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
            <option value="">Seleccionar sistema...</option>
            @foreach($sistemas as $sistema)
                <option value="{{ $sistema->id }}" {{ old('sistema_id', $documento->sistema_id ?? '') == $sistema->id ? 'selected' : '' }}>
                    {{ $sistema->nombre }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('sistema_id')" />
    </div>

    <!-- Release -->
    <div>
        <x-input-label for="release_id" value="Release" />
        <select id="release_id" name="release_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
            <option value="">Sin release</option>
            @foreach($releases as $release)
                <option value="{{ $release->id }}" {{ old('release_id', $documento->release_id ?? '') == $release->id ? 'selected' : '' }}>
                    {{ $release->version }} - {{ $release->sistema->nombre }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('release_id')" />
    </div>

    <!-- Título -->
    <div>
        <x-input-label for="titulo" value="Título *" />
        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo', $documento->titulo ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
    </div>

    <!-- Tipo -->
    <div>
        <x-input-label for="tipo" value="Tipo *" />
        <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
            <option value="manual_tecnico" {{ old('tipo', $documento->tipo ?? '') === 'manual_tecnico' ? 'selected' : '' }}>Manual Técnico</option>
            <option value="manual_usuario" {{ old('tipo', $documento->tipo ?? '') === 'manual_usuario' ? 'selected' : '' }}>Manual Usuario</option>
            <option value="runbook" {{ old('tipo', $documento->tipo ?? '') === 'runbook' ? 'selected' : '' }}>Runbook</option>
            <option value="adr" {{ old('tipo', $documento->tipo ?? '') === 'adr' ? 'selected' : '' }}>ADR</option>
            <option value="postmortem" {{ old('tipo', $documento->tipo ?? '') === 'postmortem' ? 'selected' : '' }}>Postmortem</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
    </div>

    <!-- Estado -->
    <div>
        <x-input-label for="estado" value="Estado *" />
        <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
            <option value="borrador" {{ old('estado', $documento->estado ?? 'borrador') === 'borrador' ? 'selected' : '' }}>Borrador</option>
            <option value="publicado" {{ old('estado', $documento->estado ?? '') === 'publicado' ? 'selected' : '' }}>Publicado</option>
            <option value="archivado" {{ old('estado', $documento->estado ?? '') === 'archivado' ? 'selected' : '' }}>Archivado</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('estado')" />
    </div>
</div>
