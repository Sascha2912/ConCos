<div class="wrapper">

    <h1>{{ __('app.create_new_time_log') }}</h1>

    <form wire:submit.prevent="save" id="timelog-form">
        @csrf

        <!-- Customer Information Display -->

        <x-forms.input-field
                name="customer"
                label="{{ __('app.customer') }}"
                type="text"
                readonly="true"
                value="{{ $customer->name }}"

        />

        <x-forms.input-field
                name="date"
                label="{{ __('app.date') }}"
                type="date"
                :required="true"
                wireModel="date"
        />

        <!-- Contracts Dropdown -->
        @if(!empty($contracts))
            <x-forms.select-field
                    name="contract_id"
                    type="number"
                    label="{{ __('app.contract') }}"
                    :options="$contracts"
                    wireModel="selectedContractId"
                    wireChange="loadServices"
            />
        @endif

        <!-- Services Dropdown -->

        <div class="{{ empty($services) ? 'invisible h-0' : 'visible h-auto' }}">
            <x-forms.select-field
                    name="service_id"
                    type="number"
                    label="{{ __('app.service') }}"
                    :options="$services"
                    wireModel="selectedServiceId"
            />
        </div>

        <!-- Weitere Felder -->
        <x-forms.input-field
                name="hours"
                label="{{ __('app.hours') }}"
                type="text"
                :required="true"
                wireModel="hours"
        />

        <x-forms.textarea-field
                name="description"
                label="{{ __('app.description') }}"
                rows="9"
                wireModel="description"
        />

    </form>
    <div class="button-bottom-bar">
        <x-partials.action-link href="/timelogs"
                                class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
        <button form="timelog-form">{{ __('app.log') }}</button>
    </div>
</div>