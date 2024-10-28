@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => null,
    'wireModel' => null,
    'wireKey' => null,
    'wireChange' => null,
])

<div>
    <div class="forms-field">
        <label for="{{ $name }}">{{ $label }}:</label>
        <select
                id="{{ $name }}"
                name="{{ $name }}"
                @if($wireModel) wire:model="{{ $wireModel }}" @endif
                @if($wireKey) wire:key="{{ $wireKey }}" @endif
                @if($wireChange) wire:change="{{ $wireChange }}" @endif
        >
            <option value="default"></option>
            @foreach($options as $option)
                @if(is_object($option))
                    <option value="{{ $option->id }}" @if($selected == $option->id) selected @endif>
                        {{ $option->name }}
                    </option>
                @else
                    <option value="{{ $option }}" @if($selected == $option) selected @endif>
                        {{ $option }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
    @error($name)
    <p class="forms-error">{{ $message }}</p>
    @enderror
</div>