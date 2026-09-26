@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'hint' => null,
    'icon' => null,
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold mb-1.5" style="color: #1f2937 !important;">
            {{ $label }}
            @if ($required)
                <span style="color: #dc2626;">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                style="color: #9ca3af !important;">
                <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-5 h-5" />
            </div>
        @endif

        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
            value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full ' . ($icon ? 'pl-10' : 'pl-4') . ' pr-4 py-2.5 rounded-xl text-sm outline-none transition',
            ]) }}
            style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
            onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
    </div>

    @if ($hint)
        <p class="text-xs mt-1" style="color: #9ca3af !important;">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
    @enderror
</div>
