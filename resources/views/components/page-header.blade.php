@props(['title', 'actions' => []])

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
    
    @if(count($actions) > 0)
        <div class="flex gap-2">
            @foreach($actions as $action)
                @if(isset($action['can']) && !auth()->user()->can($action['can']))
                    @continue
                @endif
                
                @if(isset($action['href']))
                    <a href="{{ $action['href'] }}" 
                       class="inline-flex items-center px-4 py-2 bg-{{ $action['color'] ?? 'blue' }}-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{{ $action['color'] ?? 'blue' }}-700 focus:outline-none focus:ring-2 focus:ring-{{ $action['color'] ?? 'blue' }}-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        @if(isset($action['icon']))
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                            </svg>
                        @endif
                        {{ $action['label'] }}
                    </a>
                @elseif(isset($action['route']))
                    <a href="{{ route($action['route'], $action['params'] ?? []) }}" 
                       class="inline-flex items-center px-4 py-2 bg-{{ $action['color'] ?? 'blue' }}-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{{ $action['color'] ?? 'blue' }}-700 focus:outline-none focus:ring-2 focus:ring-{{ $action['color'] ?? 'blue' }}-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        @if(isset($action['icon']))
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                            </svg>
                        @endif
                        {{ $action['label'] }}
                    </a>
                @endif
            @endforeach
        </div>
    @endif
</div>
