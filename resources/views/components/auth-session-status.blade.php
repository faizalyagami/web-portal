@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm']) }} style="color: #00847c !important;">
        {{ $status }}
    </div>
@endif
