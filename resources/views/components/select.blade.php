@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'required' => false,
    'placeholder' => '-- Pilih --',
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

    <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2.5 rounded-xl text-sm outline-none transition appearance-none',
        ]) }}
        style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
        onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $key => $opt)
            <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                {{ $opt }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="text-xs mt-1" style="color: #dc2626 !important;">{{ $message }}</p>
    @enderror
</div>
