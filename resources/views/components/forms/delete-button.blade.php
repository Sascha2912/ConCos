@props(['route'])

<form action="{{ $route }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="delete-button" {{ $attributes->merge(['class' => '']) }} type="submit">
        {{ $slot ?? __('app.delete') }}
    </button>
</form>

