@props(['route'])

<form action="{{ $route }}" method="POST"
      onsubmit="return confirm( {{ __('app.are_you_sure') }});">
    @csrf
    @method('DELETE')
    <button class="delete-button" {{ $attributes->merge(['class' => '']) }} type="submit">
        {{ $slot ?? __('app.delete') }}
    </button>
</form>

