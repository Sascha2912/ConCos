<div class="wrapper">
    <h1>{{ __('app.edit_time_entry') }}</h1>
    <form wire:submit.prevent="save" id="timelog-form">
        @csrf

        <input type="number" wire:model="customer_id" hidden>
        <input type="number" wire:model="contract_id" hidden>
        <input type="number" wire:model="service_id" hidden>

        <x-forms.input-field
                name="hours"
                label="{{ __('app.hours') }}"
                type="text"
                wireModel="hours"
                :required="true"
        />

        <x-forms.input-field
                name="date"
                label="{{ __('app.date') }}"
                type="date"
                wireModel="date"
                :required="true"
        />

        <x-forms.textarea-field
                name="description"
                label="{{ __('app.description') }}"
                type="text"
                wireModel="description"
                rows="9"
        />
    </form>
    <div class="button-bottom-bar">
        <x-partials.action-link href="{{ route('timelogs.index', $timelog->customer->id) }}"
                                class="back">{{ __('app.back') }}</x-partials.action-link>
        <button class="delete"
                wire:click="deleteTimelog({{ $timelog->id }})">
            {{ __('app.delete') }}
        </button>
        <button form="timelog-form">{{ __('app.save') }}</button>
    </div>
</div>
