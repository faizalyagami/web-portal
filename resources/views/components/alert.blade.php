@props(['type' => 'success'])

@php
    $styles = [
        'success' =>
            'background: rgba(0, 167, 156, 0.08) !important; border: 1px solid rgba(0, 167, 156, 0.25); color: #00847c !important;',
        'error' =>
            'background: rgba(239, 68, 68, 0.08) !important; border: 1px solid rgba(239, 68, 68, 0.25); color: #dc2626 !important;',
        'warning' =>
            'background: rgba(246, 147, 32, 0.08) !important; border: 1px solid rgba(246, 147, 32, 0.25); color: #b8690a !important;',
        'info' =>
            'background: rgba(107, 86, 165, 0.08) !important; border: 1px solid rgba(107, 86, 165, 0.25); color: #6B56A5 !important;',
    ];

    $icons = [
        'success' => 'check-circle',
        'error' => 'x-circle',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-start gap-3 p-4 rounded-xl']) }} style="{{ $styles[$type] }}">
    <x-dynamic-component :component="'heroicon-o-' . $icons[$type]" class="w-5 h-5 flex-shrink-0 mt-0.5" />
    <div class="text-sm font-medium flex-1">{{ $slot }}</div>
</div>
