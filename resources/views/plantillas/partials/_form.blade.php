@php
    $plantillaDocumento = $plantillaDocumento ?? null;
@endphp

<div class="grid grid-cols-1 gap-6">
    <!-- Nombre -->
    <div>
        <x-input-label for="nombre" value="Nombre *" />
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $plantillaDocumento->nombre ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tipo -->
        <div>
            <x-input-label for="tipo" value="Tipo *" />
            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="manual_tecnico" {{ old('tipo', $plantillaDocumento->tipo ?? '') === 'manual_tecnico' ? 'selected' : '' }}>Manual Técnico</option>
                <option value="manual_usuario" {{ old('tipo', $plantillaDocumento->tipo ?? '') === 'manual_usuario' ? 'selected' : '' }}>Manual Usuario</option>
                <option value="runbook" {{ old('tipo', $plantillaDocumento->tipo ?? '') === 'runbook' ? 'selected' : '' }}>Runbook</option>
                <option value="adr" {{ old('tipo', $plantillaDocumento->tipo ?? '') === 'adr' ? 'selected' : '' }}>ADR</option>
                <option value="postmortem" {{ old('tipo', $plantillaDocumento->tipo ?? '') === 'postmortem' ? 'selected' : '' }}>Postmortem</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
        </div>

        <!-- Formato -->
        <div>
            <x-input-label for="formato" value="Formato *" />
            <select id="formato" name="formato" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="markdown" {{ old('formato', $plantillaDocumento->formato ?? 'markdown') === 'markdown' ? 'selected' : '' }}>Markdown</option>
                <option value="html" {{ old('formato', $plantillaDocumento->formato ?? '') === 'html' ? 'selected' : '' }}>HTML</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('formato')" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Versión -->
        <div>
            <x-input-label for="version" value="Versión" />
            <x-text-input id="version" name="version" type="text" class="mt-1 block w-full" :value="old('version', $plantillaDocumento->version ?? '')" placeholder="ej: 1.0.0" />
            <x-input-error class="mt-2" :messages="$errors->get('version')" />
        </div>

        <!-- Activa -->
        <div>
            <x-input-label for="activa" value="Estado" />
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activa" value="1" {{ old('activa', $plantillaDocumento->activa ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">Activa</span>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('activa')" />
        </div>
    </div>

    <!-- Contenido Template -->
    <div>
        <x-input-label for="contenido_template" value="Contenido de la Plantilla *" />
        <textarea id="contenido_template" name="contenido_template" rows="20" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm font-mono text-sm" required>{{ old('contenido_template', $plantillaDocumento->contenido_template ?? '') }}</textarea>
        <p class="mt-1 text-sm text-gray-500">Usa placeholders como {{ '{{' }}nombre{{ '}}' }}, {{ '{{' }}version{{ '}}' }}, etc.</p>
        <x-input-error class="mt-2" :messages="$errors->get('contenido_template')" />
    </div>
</div>
