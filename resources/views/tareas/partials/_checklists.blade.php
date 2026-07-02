<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Checklists</h3>
        @can('create', \App\Models\Checklist::class)
            <button onclick="document.getElementById('checklist-form').classList.toggle('hidden')" class="text-sm text-blue-600 hover:text-blue-800">
                Nuevo Checklist
            </button>
        @endcan
    </div>

    @if($tarea->checklists->count() > 0)
        <div class="space-y-4">
            @foreach($tarea->checklists as $checklist)
                <div class="border rounded p-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-900">{{ $checklist->titulo }}</h4>
                        @can('delete', $checklist)
                            <form method="POST" action="#" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800" onclick="return confirm('¿Eliminar checklist?')">Eliminar</button>
                            </form>
                        @endcan
                    </div>
                    
                    @if($checklist->items->count() > 0)
                        <div class="space-y-2">
                            @foreach($checklist->items->sortBy('orden') as $item)
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           {{ $item->done ? 'checked' : '' }}
                                           onchange="toggleChecklistItem({{ $item->id }})"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label class="ml-2 text-sm {{ $item->done ? 'line-through text-gray-500' : 'text-gray-900' }}">
                                        {{ $item->texto }}
                                    </label>
                                    @if($item->done && $item->doneBy)
                                        <span class="ml-2 text-xs text-gray-500">
                                            ({{ $item->doneBy->name }}, {{ $item->done_at ? $item->done_at->format('d/m/Y') : '' }})
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Sin items en este checklist.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">No hay checklists aún.</p>
    @endif
</div>

<script>
function toggleChecklistItem(itemId) {
    // Implementar toggle via AJAX
    fetch(`/checklist-items/${itemId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
}
</script>
