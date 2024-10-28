<button class="x" {{ $attributes->merge(['class' => '']) }}>
    {!! $slot->isEmpty() ? '&times;' : $slot !!}
</button>

