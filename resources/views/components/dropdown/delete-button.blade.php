<button class="delete-button-x" {{ $attributes->merge(['class' => '']) }}>
    {!! $slot->isEmpty() ? '&times;' : $slot !!}
</button>

