@props(['type' => 'success'])

@php
    $styles = [
        'success' =>
            'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-700 dark:text-green-400',
        'error' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-700 dark:text-red-400',
        'warning' =>
            'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 text-yellow-700 dark:text-yellow-400',
        'info' =>
            'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-400',
    ];

    $icons = [
        'success' => 'check-circle',
        'error' => 'x-circle',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle',
    ];
@endphp

<div {{ $attributes->merge(['class' => "flex items-start gap-3 p-4 rounded-xl border {$styles[$type]}"]) }}>
    <x-dynamic-component :component="'heroicon-o-' . $icons[$type]" class="w-5 h-5 flex-shrink-0 mt-0.5" />
    <div class="text-sm font-medium flex-1">{{ $slot }}</div>
</div>
