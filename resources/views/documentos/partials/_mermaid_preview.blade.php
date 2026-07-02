<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Diagrama Mermaid</h3>
    @if($version->mermaid_source)
        <div class="mermaid">
            {!! $version->mermaid_source !!}
        </div>
    @else
        <p class="text-gray-400 italic">Sin diagrama</p>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
<script>
    mermaid.initialize({ startOnLoad: true });
</script>
@endpush
