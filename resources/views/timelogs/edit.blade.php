<x-app-layout>
    <div class="wrapper">

        <h1>{{ __('app.edit_time_entry') }}</h1>

        <form method="POST" action="{{ route('timelogs.update', $timelog->id) }}" id="timelog-form">
            @csrf
            @method('PUT')

            <input type="number" name="customer_id" value="{{ $timelog->customer_id }}" hidden>
            <input type="number" name="contract_id" value="{{ $timelog->contract_id }}" hidden>

            <x-forms.select-field
                    name="service_id[]"
                    label="{{ __('app.service') }}"
                    :options="$services"
                    selected="{{ $timelog->service->id }}"
                    :required="true"
            />

            <x-forms.input-field
                    name="hours"
                    label="{{ __('app.hours') }}"
                    value="{{ $timelog->hours }}"
                    type="text"
                    :required="true"/>

            <x-forms.input-field
                    name="date"
                    label="{{ __('app.date') }}"
                    value="{{ $timelog->date }}"
                    type="date"
                    :required="true"/>

            <x-forms.textarea-field
                    name="description"
                    label="{{ __('app.description') }}"
                    value="{{ $timelog->description }}"
                    rows="9"
            />
        </form>

        <div class="button-bottom-bar">
            <x-partials.action-link href="/timelogs"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <button class="delete" form="delete-form">
                {{ __('app.delete') }}
            </button>
            <button form="timelog-form">{{ __('app.save') }}</button>
        </div>

        <form action="{{ route('timelogs.destroy', $timelog->id) }}" method="POST" id="delete-form">
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-app-layout>