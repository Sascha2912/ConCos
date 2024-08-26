@props(['href' => null, 'type' => 'button'])

<div class="action-btn-wrapper">
    @if($href)
        <a href="{{ $href }}" {{ $attributes->merge(['class' => 'action-btn']) }}>
            {{ $slot }}
        </a>
    @else
        <button type="{{ $type }}" {{ $attributes->merge(['class' => 'action-btn']) }}>
            {{ $slot }}
        </button>
    @endif
</div>
