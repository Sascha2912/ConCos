@props([
    'name',
    'label' => '',
    'value' => null,
    'required' => false,
    'rows' => 3,
    'readonly' => false,
    'disabled' => false,
    'wireModel' => null,
    'id' => null,
])

<div class="col-span-2">
    <div>
        <label for="{{ $id ?? $name }}">{{ $label }}:</label>
        <textarea
                name="{{ $name }}"
                id="{{ $id ?? $name }}"
                rows="{{ $rows }}"
                {{ $required ? 'required' : '' }}
                @if($readonly) readonly @endif
                @if($disabled) disabled @endif
                @if($wireModel) wire:model="{{ $wireModel }}" @endif
        >{{ $value ?? old($name) }}</textarea>
    </div>
    @error($name)
    <p class="forms-error">{{ $message }}</p>
    @enderror
</div>