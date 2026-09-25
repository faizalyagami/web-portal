@props(['title' => null, 'subtitle' => null, 'padding' => 'p-6'])

<div
    {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm']) }}>
    @if ($title)
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
            <h3 class="font-bold text-gray-800 dark:text-white">{{ $title }}</h3>
            @if ($subtitle)
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
