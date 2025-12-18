@props([
    'status',
])

@php
    $statusConfig = [
        'completed' => [
            'label' => 'Selesai',
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'icon' => 'check',
        ],
        'approved' => [
            'label' => 'Disetujui',
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-800',
            'icon' => 'circle-check',
        ],
        'pending' => [
            'label' => 'Menunggu',
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-800',
            'icon' => 'clock',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'bg' => 'bg-red-100',
            'text' => 'text-red-800',
            'icon' => 'x-mark',
        ],
    ];
    $config = $statusConfig[$status] ?? $statusConfig['pending'];
@endphp

<span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-sm font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
    @switch($config['icon'])
        @case('check')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            @break
        @case('circle-check')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            @break
        @case('clock')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            @break
        @case('x-mark')
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            @break
    @endswitch
    {{ $config['label'] }}
</span>
