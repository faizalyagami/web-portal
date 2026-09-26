@props(['title' => null, 'subtitle' => null, 'padding' => 'p-6'])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-100']) }}
    style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">

    @if ($title)
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold" style="color: #1f2937 !important;">{{ $title }}</h3>
            @if ($subtitle)
                <p class="text-sm mt-1" style="color: #9ca3af !important;">{{ $subtitle }}</p>
            @endif
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
