<x-app-layout>
    <div class="wrapper">

        <h1>{{ __('app.create_new_time_log') }}</h1>

        <form method="POST" action="{{ route('timelogs.store') }}" id="timelog-form">
            @csrf

            <input type="number" name="customer_id" value="{{ $timelog->customer_id }}" hidden>
            <input type="number" name="contract_id" value="{{ $timelog->contract_id }}" hidden>

            <x-forms.select-field
                    name="service_id[]"
                    label="{{ __('app.service') }}"
                    :options="$services"
                    :required="true"
            />
            <x-forms.input-field
                    name="hours"
                    label="{{ __('app.hours') }}"
                    type="text"
                    :required="true"/>

            <x-forms.input-field
                    name="date"
                    label="{{ __('app.date') }}"
                    type="date"
                    :required="true"/>

            <x-forms.textarea-field
                    name="description"
                    label="{{ __('app.description') }}"
                    value="{{ $tiemlog->description }}"
                    rows="9"
            />

        </form>
        <div class="button-bottom-bar">
            <x-partials.action-link href="/timelogs"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <button form="timelog-form">{{ __('app.log') }}</button>
        </div>
    </div>
</x-app-layout>