@props([
    'label',
    'value',
    'color' => 'sanku-primary',
    'icon' => 'wallet',
    'action' => null,
    'actionText' => null,
    'description' => null,
])

<div class="bg-white overflow-hidden shadow-lg rounded-2xl">
    <div class="p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-sm text-gray-600">{{ $label }}</p>
                <h3 class="text-3xl font-bold text-{{ $color }}">
                    {!! $value !!}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-{{ $color }} bg-opacity-20 flex items-center justify-center">
                @switch($icon)
                    @case('wallet')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-{{ $color }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @break
                    @case('credit-card')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-{{ $color }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        @break
                    @case('clock')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-{{ $color }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @break
                    @case('trash')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-{{ $color }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        @break
                @endswitch
            </div>
        </div>

        @if($action && $actionText)
            <a href="{{ $action }}" class="text-sm font-semibold text-{{ $color }} hover:text-sanku-primary">
                {{ $actionText }}
            </a>
        @elseif($description)
            <p class="text-sm text-gray-600">{{ $description }}</p>
        @endif
    </div>
</div>
