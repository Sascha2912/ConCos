@props([
    'name',
    'id' => null,
    'label' => '',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'wireModel' => null,
])

<div>
    <div class="forms-field">
        <label for="{{ $name }}">{{ $label }}:</label>
        <input @if($type === 'checkbox') class="input-box" @endif
        name="{{ $name }}"
               id="{{ $id ?? $name }}"
               type="{{ $type }}"
               value="{{ $value ?? old($name) }}" {{ $required ? 'required' : '' }}
               @if($readonly) readonly @endif
               @if($disabled) disabled @endif
               @if($wireModel) wire:model="{{ $wireModel }}" @endif/>
    </div>
    @error($name)
    <p class="forms-error">{{ $message }}</p>
    @enderror
</div>
