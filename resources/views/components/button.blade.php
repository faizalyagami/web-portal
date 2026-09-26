@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'type' => 'button',
])

@php
    $base =
        'inline-flex items-center justify-center gap-2 font-semibold rounded-xl transition-all focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $variants = [
        'primary' => 'text-white shadow-md hover:shadow-lg',
        'secondary' => 'border',
        'danger' => 'text-white shadow-md',
        'ghost' => '',
    ];

    $classes = "{$base} {$sizes[$size]} {$variants[$variant]}";
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}
    style="
            @if ($variant === 'primary') background: linear-gradient(135deg, #6B56A5, #56438a) !important;
            @elseif($variant === 'secondary') background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb !important;
            @elseif($variant === 'danger') background: #dc2626 !important;
            @elseif($variant === 'ghost') color: #6b7280 !important; @endif
        "
    onmouseover="
            @if ($variant === 'primary') this.style.boxShadow='0 10px 24px rgba(107, 86, 165, 0.35)'; this.style.transform='translateY(-1px)';
            @elseif($variant === 'secondary') this.style.background='#f9fafb';
            @elseif($variant === 'danger') this.style.background='#b91c1c';
            @elseif($variant === 'ghost') this.style.background='#f3f4f6'; @endif
        "
    onmouseout="
            @if ($variant === 'primary') this.style.boxShadow='0 4px 12px rgba(107, 86, 165, 0.2)'; this.style.transform='translateY(0)';
            @elseif($variant === 'secondary') this.style.background='#ffffff';
            @elseif($variant === 'danger') this.style.background='#dc2626';
            @elseif($variant === 'ghost') this.style.background='transparent'; @endif
        ">
    @if ($icon)
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-4 h-4" />
    @endif
    {{ $slot }}
</button>
