@props(['items', 'active' => null])

<div class="border-b border-gray-200">
    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
        @foreach($items as $item)
            @php
                $isActive = ($active ?? $items[0]['key']) === $item['key'];
                $href = $item['href'] ?? '#';
            @endphp
            <a href="{{ $href }}" 
               class="@if($isActive) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                @if(isset($item['icon']))
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                @endif
                {{ $item['label'] }}
                @if(isset($item['badge']))
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $item['badge'] }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>
</div>
