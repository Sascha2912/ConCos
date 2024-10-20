@props(['onClick'])

<button type="button" {{ $attributes->merge(['class' => 'delete-button']) }} wire:click="{{ $onClick }}">
    {{ $slot ?? __('app.delete') }}
</button>
