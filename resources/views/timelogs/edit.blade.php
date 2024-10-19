<x-app-layout>
    <form method="POST" action="{{ route('timelogs.update', $timelog->id) }}">
        @csrf
        @method('PUT')

        <div class="form-input-wrapper">
            <h1>{{ __('app.edit_time_entry') }}</h1>
            <div class="edit-wrapper">
                <x-forms.label for="customer_id[]">{{ __('app.customer') }}:</x-forms.label>
                <select name="customer_id" required>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                                @if($timelog->customer_id == $customer->id) selected @endif>{{ $customer->firstname }} {{ $customer->lastname }}</option>
                    @endforeach
                </select>

                <x-forms.label>{{ __('app.contract') }}:</x-forms.label>
                <select name="contract_id" required>
                    @foreach($contracts as $contract)
                        <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                    @endforeach
                </select>

                <x-forms.label for="service_id[]">{{ __('app.service') }}:</x-forms.label>
                <select name="service_id" required>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}"
                                @if($timelog->service_id == $service->id) selected @endif>{{ $service->name }}</option>
                    @endforeach
                </select>

                <input type="number" name="contract_id" value="{{ $timelog->contract_id }}" hidden>

                <x-forms.field>
                    <x-forms.label for="hours">{{ __('app.hours') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="hours" id="hours" value="{{ $timelog->hours }}"/>

                        <x-forms.error name="hours"/>
                    </div>
                </x-forms.field>

                <x-forms.field>
                    <x-forms.label for="date">{{ __('app.date') }}:</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input name="date" id="date" value="{{ $timelog->date }}"/>

                        <x-forms.error name="date"/>
                    </div>
                </x-forms.field>

            </div>
        </div>

        <div class="button-bar">
            <x-partials.action-link href="/timelogs"
                                    class="back text-sm font-semibold leading-6 text-gray-900">{{ __('app.back') }}</x-partials.action-link>
            <x-forms.delete-button :route="route('timelogs.destroy', $timelog->id)"
                                   class="delete-button">{{ __('app.delete') }}</x-forms.delete-button>
            <x-forms.button>{{ __('app.save') }}</x-forms.button>
        </div>
    </form>
</x-app-layout>