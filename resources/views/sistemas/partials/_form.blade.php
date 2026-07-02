@php
    $sistema = $sistema ?? null;
@endphp

<div class="grid grid-cols-1 gap-6">
    <!-- Nombre -->
    <div>
        <x-input-label for="nombre" value="Nombre *" />
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $sistema->nombre ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
    </div>

    <!-- Slug -->
    <div>
        <x-input-label for="slug" value="Slug *" />
        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $sistema->slug ?? '')" required />
        <p class="mt-1 text-sm text-gray-500">Se genera automáticamente desde el nombre</p>
        <x-input-error class="mt-2" :messages="$errors->get('slug')" />
    </div>

    <!-- Descripción -->
    <div>
        <x-input-label for="descripcion" value="Descripción" />
        <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('descripcion', $sistema->descripcion ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Área Usuaria -->
        <div>
            <x-input-label for="area_usuaria" value="Área Usuaria" />
            <x-text-input id="area_usuaria" name="area_usuaria" type="text" class="mt-1 block w-full" :value="old('area_usuaria', $sistema->area_usuaria ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('area_usuaria')" />
        </div>

        <!-- Dueño Funcional -->
        <div>
            <x-input-label for="dueno_funcional" value="Dueño Funcional" />
            <x-text-input id="dueno_funcional" name="dueno_funcional" type="text" class="mt-1 block w-full" :value="old('dueno_funcional', $sistema->dueno_funcional ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('dueno_funcional')" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Criticidad -->
        <div>
            <x-input-label for="criticidad" value="Criticidad *" />
            <select id="criticidad" name="criticidad" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="">Seleccionar...</option>
                <option value="alta" {{ old('criticidad', $sistema->criticidad ?? '') === 'alta' ? 'selected' : '' }}>Alta</option>
                <option value="media" {{ old('criticidad', $sistema->criticidad ?? 'media') === 'media' ? 'selected' : '' }}>Media</option>
                <option value="baja" {{ old('criticidad', $sistema->criticidad ?? '') === 'baja' ? 'selected' : '' }}>Baja</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('criticidad')" />
        </div>

        <!-- Estatus -->
        <div>
            <x-input-label for="estatus" value="Estatus *" />
            <select id="estatus" name="estatus" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                <option value="">Seleccionar...</option>
                <option value="activo" {{ old('estatus', $sistema->estatus ?? 'activo') === 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="mantenimiento" {{ old('estatus', $sistema->estatus ?? '') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                <option value="legado" {{ old('estatus', $sistema->estatus ?? '') === 'legado' ? 'selected' : '' }}>Legado</option>
                <option value="deprecado" {{ old('estatus', $sistema->estatus ?? '') === 'deprecado' ? 'selected' : '' }}>Deprecado</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('estatus')" />
        </div>
    </div>

    <!-- URLs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <x-input-label for="url_prod" value="URL Producción" />
            <x-text-input id="url_prod" name="url_prod" type="url" class="mt-1 block w-full" :value="old('url_prod', $sistema->url_prod ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('url_prod')" />
        </div>
        <div>
            <x-input-label for="url_qa" value="URL QA" />
            <x-text-input id="url_qa" name="url_qa" type="url" class="mt-1 block w-full" :value="old('url_qa', $sistema->url_qa ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('url_qa')" />
        </div>
        <div>
            <x-input-label for="url_dev" value="URL Dev" />
            <x-text-input id="url_dev" name="url_dev" type="url" class="mt-1 block w-full" :value="old('url_dev', $sistema->url_dev ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('url_dev')" />
        </div>
    </div>

    <!-- Repositorio -->
    <div>
        <x-input-label for="repositorio_url" value="URL Repositorio" />
        <x-text-input id="repositorio_url" name="repositorio_url" type="url" class="mt-1 block w-full" :value="old('repositorio_url', $sistema->repositorio_url ?? '')" />
        <x-input-error class="mt-2" :messages="$errors->get('repositorio_url')" />
    </div>
</div>
