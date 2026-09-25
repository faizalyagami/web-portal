@props([
    'variant' => 'primary', // primary, secondary, danger, ghost, gold
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'type' => 'button',
])

@php
    $base =
        'inline-flex items-center justify-center gap-2 font-semibold rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $variants = [
        'primary' => 'bg-[#0d7a3f] hover:bg-[#085c2d] text-white shadow-md hover:shadow-lg focus:ring-[#0d7a3f]',
        'secondary' =>
            'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-gray-300',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-md focus:ring-red-500',
        'gold' =>
            'bg-gradient-to-r from-[#c9a227] to-[#e8c547] text-[#0d7a3f] font-bold shadow-md hover:shadow-lg focus:ring-[#c9a227]',
        'ghost' => 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:ring-gray-300',
    ];

    $classes = "{$base} {$sizes[$size]} {$variants[$variant]}";
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-4 h-4" />
    @endif
    {{ $slot }}
</button>
