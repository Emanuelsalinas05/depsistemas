<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Contenido</h3>
    <div class="prose max-w-none">
        @if($version->contenido)
            {!! \Illuminate\Support\Str::markdown($version->contenido) !!}
        @else
            <p class="text-gray-400 italic">Sin contenido</p>
        @endif
    </div>
</div>
