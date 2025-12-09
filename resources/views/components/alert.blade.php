@props(['type' => 'info', 'title' => '', 'message' => ''])

@php
$colors = [
    'success' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-700', 'icon' => '✓'],
    'error' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-700', 'icon' => '⚠'],
    'warning' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-700', 'icon' => '!'],
    'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700', 'icon' => 'ℹ'],
];
$color = $colors[$type] ?? $colors['info'];
@endphp

<div class="p-4 {{ $color['bg'] }} border {{ $color['border'] }} rounded-lg {{ $color['text'] }}">
    @if ($title)
        <p class="font-bold mb-2">{{ $color['icon'] }} {{ $title }}</p>
    @endif
    {{ $slot }}
</div>
