<button {{ $attributes->merge(['class' => '']) }}>
    {!! $slot->isEmpty() ? '&times;' : $slot !!}
</button>

