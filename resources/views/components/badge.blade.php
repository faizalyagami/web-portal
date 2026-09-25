@props(['color' => '#0d7a3f', 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'px-2 py-0.5 text-[10px]',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];
@endphp

<span
    {{ $attributes->merge([
        'class' =>
            'inline-flex items-center gap-1 rounded-full font-semibold uppercase tracking-wide ' . $sizeClasses[$size],
        'style' => "background: {$color}20; color: {$color}",
    ]) }}>
    {{ $slot }}
</span>
