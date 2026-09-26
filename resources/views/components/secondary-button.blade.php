<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' =>
            'inline-flex items-center px-4 py-2 rounded-xl font-semibold text-xs uppercase tracking-widest transition',
    ]) }}
    style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb !important;"
    onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#ffffff'">
    {{ $slot }}
</button>
